<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Plantilla;

class CorregirSueldosAltos extends Command
{
    protected $signature = 'plantilla:corregir-altos 
                            {--fix : Aplicar correcciones}
                            {--dry-run : Solo mostrar qué se corregiría}
                            {--limite=150000 : Límite máximo de sueldo razonable}';

    protected $description = 'Corrige sueldos muy altos que fueron calculados incorrectamente';

    public function handle()
    {
        $limite = (float) $this->option('limite');
        
        $this->info("🔍 Verificando sueldos muy altos (>{$limite})...");
        $this->newLine();

        // Obtener registros con sueldos muy altos
        $muyAltos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '>', $limite)
            ->orderBy('omonto_mensual', 'DESC')
            ->get();

        if ($muyAltos->isEmpty()) {
            $this->info('✅ No se encontraron sueldos muy altos.');
            return 0;
        }

        $this->warn("⚠️  Se encontraron {$muyAltos->count()} registros con sueldos > {$limite}");
        $this->newLine();

        $correcciones = [];
        $noCorregibles = [];

        foreach ($muyAltos as $plantilla) {
            $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                         ($plantilla->ohoras_docencia ?? 0) + 
                         ($plantilla->ohoras_compatibilidad ?? 0);
            
            $sueldoActual = $plantilla->omonto_mensual;
            $sueldoCorregido = null;
            $razon = '';

            if ($totalHoras > 0) {
                // Calcular sueldo por hora asumiendo horas semanales
                $sueldoPorHoraSemanal = round($sueldoActual / ($totalHoras * 4.33), 2);
                
                // Si el sueldo por hora es muy alto (> 500), probablemente se multiplicó incorrectamente
                if ($sueldoPorHoraSemanal > 500) {
                    // Opción 1: Las horas son MENSUALES, no semanales
                    $sueldoPorHoraMensual = round($sueldoActual / $totalHoras, 2);
                    
                    if ($sueldoPorHoraMensual >= 50 && $sueldoPorHoraMensual <= 500) {
                        // Las horas son mensuales, el sueldo está correcto
                        // No corregir
                        $noCorregibles[] = [
                            'plantilla' => $plantilla,
                            'razon' => "Horas son mensuales, sueldo correcto"
                        ];
                        continue;
                    }
                    
                    // Opción 2: El valor original era mensual y se multiplicó incorrectamente
                    // Revertir: dividir por el factor de multiplicación
                    $sueldoOriginal = round($sueldoActual / ($totalHoras * 4.33), 2);
                    
                    // Verificar si el sueldo original es razonable
                    if ($sueldoOriginal >= 5000 && $sueldoOriginal <= $limite) {
                        // El valor original era mensual y se multiplicó incorrectamente
                        $sueldoCorregido = $sueldoOriginal;
                        $razon = "Revertir cálculo incorrecto (valor original era mensual)";
                    } elseif ($sueldoOriginal >= 50 && $sueldoOriginal <= 1000) {
                        // El valor original era por hora
                        // Si las horas son > 40, probablemente son MENSUALES, no semanales
                        if ($totalHoras > 40) {
                            // Las horas son mensuales, recalcular: sueldo_hora × horas_mensuales
                            $sueldoCorregido = round($sueldoOriginal * $totalHoras, 2);
                            $razon = "Horas son mensuales, recalcular";
                        } else {
                            // Horas semanales (≤ 40), el cálculo original podría ser correcto
                            // Pero el resultado es muy alto, así que revisar
                            // No corregir automáticamente, requiere revisión manual
                            $noCorregibles[] = [
                                'plantilla' => $plantilla,
                                'razon' => "Horas semanales, sueldo por hora: {$sueldoOriginal} - Revisar manualmente"
                            ];
                            continue;
                        }
                    }
                } else {
                    // El sueldo por hora es razonable, el valor podría ser correcto
                    $noCorregibles[] = [
                        'plantilla' => $plantilla,
                        'razon' => "Sueldo por hora razonable: {$sueldoPorHoraSemanal}"
                    ];
                }
            } else {
                // Sin horas registradas, no se puede determinar
                $noCorregibles[] = [
                    'plantilla' => $plantilla,
                    'razon' => "Sin horas registradas"
                ];
            }

            if ($sueldoCorregido && $sueldoCorregido >= 5000 && $sueldoCorregido <= $limite) {
                $correcciones[] = [
                    'plantilla' => $plantilla,
                    'actual' => $sueldoActual,
                    'corregido' => $sueldoCorregido,
                    'razon' => $razon
                ];
            }
        }

        if (empty($correcciones)) {
            $this->info('✅ No se encontraron correcciones automáticas posibles.');
            $this->warn("⚠️  {$noCorregibles} registros requieren revisión manual.");
            return 0;
        }

        $this->info("📋 Se pueden corregir " . count($correcciones) . " registros:");
        $this->newLine();

        $headers = ['ID', 'Clave', 'Sueldo Actual', 'Sueldo Corregido', 'Razón'];
        $rows = [];

        foreach (array_slice($correcciones, 0, 20) as $corr) {
            $rows[] = [
                $corr['plantilla']->id,
                $corr['plantilla']->oclave ?? 'N/A',
                number_format($corr['actual'], 2),
                number_format($corr['corregido'], 2),
                $corr['razon']
            ];
        }

        $this->table($headers, $rows);

        if (count($correcciones) > 20) {
            $this->warn("... y " . (count($correcciones) - 20) . " más");
        }

        $this->newLine();

        if ($this->option('dry-run')) {
            $this->info('💡 Para aplicar: php artisan plantilla:corregir-altos --fix');
            return 0;
        }

        if (!$this->option('fix')) {
            $this->info('💡 Para ver qué se corregiría: php artisan plantilla:corregir-altos --dry-run');
            $this->info('💡 Para corregir: php artisan plantilla:corregir-altos --fix');
            return 0;
        }

        if (!$this->confirm('¿Deseas aplicar las correcciones?', false)) {
            $this->info('Operación cancelada.');
            return 0;
        }

        $this->info('🔧 Aplicando correcciones...');
        $corregidos = 0;

        DB::beginTransaction();
        try {
            foreach ($correcciones as $corr) {
                $corr['plantilla']->omonto_mensual = $corr['corregido'];
                $corr['plantilla']->save();
                $corregidos++;

                if ($corregidos <= 20) {
                    $this->line("  ✅ {$corr['plantilla']->oclave}: " . 
                               number_format($corr['actual'], 2) . 
                               " → " . 
                               number_format($corr['corregido'], 2));
                }
            }

            DB::commit();
            $this->newLine();
            $this->info("✅ Se corrigieron {$corregidos} registros exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

