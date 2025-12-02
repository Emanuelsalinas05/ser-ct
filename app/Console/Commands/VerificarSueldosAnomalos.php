<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Plantilla;

class VerificarSueldosAnomalos extends Command
{
    protected $signature = 'plantilla:verificar-anomalos 
                            {--fix : Corregir valores anómalos}
                            {--dry-run : Solo mostrar qué se corregiría}';

    protected $description = 'Verifica y corrige sueldos anómalos (muy altos o muy bajos)';

    public function handle()
    {
        $this->info('🔍 Verificando sueldos anómalos...');
        $this->newLine();

        // Valores muy altos (probablemente calculados incorrectamente)
        // Un sueldo mensual razonable máximo sería ~150,000 para puestos de alto nivel
        $muyAltos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '>', 150000)
            ->orderBy('omonto_mensual', 'DESC')
            ->get();

        // Valores muy bajos (no corregidos o errores)
        $muyBajos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '>', 0)
            ->where('omonto_mensual', '<', 50)
            ->orderBy('omonto_mensual', 'ASC')
            ->get();

        // Valores en cero
        $ceros = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '=', 0)
            ->get();

        $this->info("📊 Estadísticas de valores anómalos:");
        $this->line("   🔴 Valores muy altos (> 150,000): {$muyAltos->count()}");
        $this->line("   🟡 Valores muy bajos (< 50): {$muyBajos->count()}");
        $this->line("   ❌ Valores en cero: {$ceros->count()}");
        $this->newLine();

        if ($muyAltos->isEmpty() && $muyBajos->isEmpty() && $ceros->isEmpty()) {
            $this->info('✅ No se encontraron valores anómalos.');
            return 0;
        }

        // Analizar valores muy altos
        if ($muyAltos->isNotEmpty()) {
            $this->warn("⚠️  VALORES MUY ALTOS (probablemente calculados incorrectamente):");
            $this->newLine();

            $headers = ['ID', 'Clave', 'Sueldo Actual', 'Horas', 'Sueldo/Hora Calculado', 'Estado'];
            $rows = [];

            foreach ($muyAltos->take(20) as $plantilla) {
                $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                             ($plantilla->ohoras_docencia ?? 0) + 
                             ($plantilla->ohoras_compatibilidad ?? 0);
                
                // Calcular qué sueldo por hora daría este resultado
                $sueldoPorHoraCalculado = $totalHoras > 0 
                    ? round($plantilla->omonto_mensual / ($totalHoras * 4.33), 2)
                    : 0;

                $estado = '❌ ANÓMALO';
                if ($sueldoPorHoraCalculado > 0 && $sueldoPorHoraCalculado < 200) {
                    $estado = '⚠️ REVISAR';
                }

                $rows[] = [
                    $plantilla->id,
                    $plantilla->oclave ?? 'N/A',
                    number_format($plantilla->omonto_mensual, 2),
                    $totalHoras > 0 ? $totalHoras : 'Sin horas',
                    $sueldoPorHoraCalculado > 0 ? number_format($sueldoPorHoraCalculado, 2) : 'N/A',
                    $estado
                ];
            }

            $this->table($headers, $rows);
            
            if ($muyAltos->count() > 20) {
                $this->warn("... y " . ($muyAltos->count() - 20) . " más");
            }
            $this->newLine();
        }

        // Analizar valores muy bajos
        if ($muyBajos->isNotEmpty()) {
            $this->warn("⚠️  VALORES MUY BAJOS (no corregidos o errores):");
            $this->newLine();

            $headers = ['ID', 'Clave', 'Sueldo Actual', 'Horas', 'Acción Sugerida'];
            $rows = [];

            foreach ($muyBajos->take(20) as $plantilla) {
                $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                             ($plantilla->ohoras_docencia ?? 0) + 
                             ($plantilla->ohoras_compatibilidad ?? 0);

                $accion = 'Revisar manualmente';
                if ($totalHoras > 0) {
                    $sueldoCorregido = round($plantilla->omonto_mensual * $totalHoras * 4.33, 2);
                    $accion = "Corregir: " . number_format($sueldoCorregido, 2);
                } elseif ($plantilla->omonto_mensual >= 0.20) {
                    $sueldoCorregido = round($plantilla->omonto_mensual * 40 * 4.33, 2);
                    $accion = "Estimar: " . number_format($sueldoCorregido, 2) . " (40 hrs/sem)";
                }

                $rows[] = [
                    $plantilla->id,
                    $plantilla->oclave ?? 'N/A',
                    number_format($plantilla->omonto_mensual, 2),
                    $totalHoras > 0 ? $totalHoras : 'Sin horas',
                    $accion
                ];
            }

            $this->table($headers, $rows);
            
            if ($muyBajos->count() > 20) {
                $this->warn("... y " . ($muyBajos->count() - 20) . " más");
            }
            $this->newLine();
        }

        if ($this->option('dry-run')) {
            $this->info('💡 Para aplicar correcciones: php artisan plantilla:verificar-anomalos --fix');
            return 0;
        }

        if (!$this->option('fix')) {
            $this->info('💡 Para ver qué se corregiría: php artisan plantilla:verificar-anomalos --dry-run');
            $this->info('💡 Para corregir: php artisan plantilla:verificar-anomalos --fix');
            return 0;
        }

        // Aplicar correcciones
        $this->warn('⚠️  ADVERTENCIA: Esta operación modificará valores anómalos.');
        if (!$this->confirm('¿Deseas aplicar las correcciones?', false)) {
            $this->info('Operación cancelada.');
            return 0;
        }

        $this->info('🔧 Aplicando correcciones...');
        $corregidos = 0;

        // Corregir valores muy altos: analizar si el cálculo fue incorrecto
        foreach ($muyAltos as $plantilla) {
            $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                         ($plantilla->ohoras_docencia ?? 0) + 
                         ($plantilla->ohoras_compatibilidad ?? 0);
            
            if ($totalHoras > 0) {
                // Calcular sueldo por hora asumiendo que horas son semanales
                $sueldoPorHoraSemanal = round($plantilla->omonto_mensual / ($totalHoras * 4.33), 2);
                
                // Si el sueldo por hora es muy alto (> 500), probablemente:
                // 1. El valor original ya era mensual y se multiplicó incorrectamente
                // 2. Las horas son mensuales, no semanales
                
                if ($sueldoPorHoraSemanal > 500) {
                    // Intentar corregir asumiendo que las horas son MENSUALES
                    $sueldoCorregidoMensual = round($plantilla->omonto_mensual / $totalHoras, 2);
                    
                    // Si el resultado es razonable (entre 500 y 2000), probablemente es correcto
                    if ($sueldoCorregidoMensual >= 500 && $sueldoCorregidoMensual <= 2000) {
                        // Las horas son mensuales, el sueldo ya está correcto
                        // No hacer nada, el valor es correcto
                        continue;
                    }
                    
                    // Si el sueldo por hora mensual también es muy alto, 
                    // probablemente el valor original ya era mensual y se multiplicó incorrectamente
                    if ($sueldoCorregidoMensual > 2000) {
                        // Revertir el cálculo: el valor original probablemente era mensual
                        // Dividir por horas y semanas para obtener el sueldo por hora original
                        $sueldoPorHoraOriginal = round($plantilla->omonto_mensual / ($totalHoras * 4.33), 2);
                        
                        // Si el sueldo por hora es razonable (50-500), corregir
                        if ($sueldoPorHoraOriginal >= 50 && $sueldoPorHoraOriginal <= 500) {
                            // El valor original era por hora, pero se multiplicó incorrectamente
                            // Mantener el cálculo pero verificar
                            $this->warn("  ⚠️  {$plantilla->oclave}: {$plantilla->omonto_mensual} - Sueldo por hora: {$sueldoPorHoraOriginal} - Revisar");
                        } else {
                            // Probablemente el valor original ya era mensual completo
                            // Revertir completamente: dividir por el factor de multiplicación
                            $sueldoCorregido = round($plantilla->omonto_mensual / ($totalHoras * 4.33), 2);
                            
                            // Solo corregir si el resultado es razonable
                            if ($sueldoCorregido >= 5000 && $sueldoCorregido <= 150000) {
                                $plantilla->omonto_mensual = $sueldoCorregido;
                                $plantilla->save();
                                $corregidos++;
                                
                                if ($corregidos <= 20) {
                                    $this->line("  ✅ {$plantilla->oclave}: " . 
                                               number_format($plantilla->omonto_mensual, 2) . 
                                               " → " . 
                                               number_format($sueldoCorregido, 2) . 
                                               " (revertido cálculo incorrecto)");
                                }
                            }
                        }
                    }
                }
            }
        }

        // Corregir valores muy bajos
        foreach ($muyBajos as $plantilla) {
            $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                         ($plantilla->ohoras_docencia ?? 0) + 
                         ($plantilla->ohoras_compatibilidad ?? 0);
            
            $sueldoActual = $plantilla->omonto_mensual;
            $sueldoCorregido = null;

            if ($totalHoras > 0 && $sueldoActual > 0) {
                $horasMensuales = $totalHoras * 4.33;
                $sueldoCorregido = round($sueldoActual * $horasMensuales, 2);
            } elseif ($sueldoActual >= 0.20 && $sueldoActual < 50) {
                // Asumir jornada estándar de 40 horas/semana
                $horasMensuales = 40 * 4.33;
                $sueldoCorregido = round($sueldoActual * $horasMensuales, 2);
            }

            if ($sueldoCorregido && $sueldoCorregido >= 1000 && $sueldoCorregido <= 150000) {
                $plantilla->omonto_mensual = $sueldoCorregido;
                $plantilla->save();
                $corregidos++;
                
                if ($corregidos <= 20) {
                    $this->line("  ✅ {$plantilla->oclave}: " . 
                               number_format($sueldoActual, 2) . 
                               " → " . 
                               number_format($sueldoCorregido, 2));
                }
            }
        }

        $this->newLine();
        $this->info("✅ Se corrigieron {$corregidos} registros.");
        $this->warn("⚠️  Los valores muy altos requieren revisión manual para determinar si son correctos.");

        return 0;
    }
}

