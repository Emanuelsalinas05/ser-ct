<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Plantilla;

class VerificarSueldosPlantilla extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plantilla:verificar-sueldos 
                            {--fix : Corregir automáticamente los valores problemáticos}
                            {--dry-run : Solo mostrar qué se corregiría sin hacer cambios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica y corrige sueldos incorrectos en la tabla g1claves_plantilla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando sueldos en plantilla de personal...');
        $this->newLine();

        // Obtener registros problemáticos
        // Incluir valores desde 0.10 en adelante (excluir solo ceros y valores extremadamente bajos < 0.10)
        // Los valores muy bajos también pueden ser sueldos por hora/día que necesitan corrección
        $problematicos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '<', 1000)
            ->where('omonto_mensual', '>=', 0.10) // Incluir valores desde 0.10
            ->orderBy('omonto_mensual', 'ASC')
            ->get();

        // Obtener estadísticas generales
        $totalRegistros = Plantilla::where('ocm', 0)->count();
        $totalCeros = Plantilla::where('ocm', 0)->where('omonto_mensual', '=', 0)->count();
        $totalMuyBajos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '>', 0)
            ->where('omonto_mensual', '<', 50)
            ->count();
        $totalCorrectos = Plantilla::where('ocm', 0)
            ->where('omonto_mensual', '>=', 1000)
            ->count();

        $this->info("📊 Estadísticas de la tabla g1claves_plantilla (ocm=0):");
        $this->line("   Total de registros: {$totalRegistros}");
        $this->line("   ✅ Sueldos correctos (>= 1,000): {$totalCorrectos}");
        $this->line("   ⚠️  Sueldos a revisar (50 - 1,000): {$problematicos->count()}");
        $this->line("   🔴 Valores muy bajos (< 50): {$totalMuyBajos}");
        $this->line("   ❌ Valores en cero: {$totalCeros}");
        $this->newLine();

        if ($problematicos->isEmpty()) {
            $this->info('✅ No se encontraron registros problemáticos que necesiten corrección automática.');
            if ($totalCeros > 0 || $totalMuyBajos > 0) {
                $this->warn("⚠️  Pero hay {$totalCeros} registros en cero y {$totalMuyBajos} con valores muy bajos que requieren revisión manual.");
            }
            return 0;
        }

        $this->warn("⚠️  Se encontraron {$problematicos->count()} registros con sueldos entre 50 y 1,000 que pueden necesitar corrección");
        $this->newLine();

        // Mostrar tabla de problemas (limitada a los primeros 30)
        $headers = ['ID', 'Clave', 'Descripción', 'Sueldo Actual', 'Horas', 'Tipo Detectado', 'Estado'];
        $rows = [];
        $mostrarTodos = $this->option('fix') || $problematicos->count() <= 30;
        $limit = $mostrarTodos ? $problematicos->count() : 30;

        foreach ($problematicos->take($limit) as $plantilla) {
            $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                         ($plantilla->ohoras_docencia ?? 0) + 
                         ($plantilla->ohoras_compatibilidad ?? 0);
            
            $sueldoActual = $plantilla->omonto_mensual;
            $tipoDetectado = 'Desconocido';
            $estado = '🟡 REVISAR';
            
            // Detectar tipo de problema
            if ($totalHoras > 0 && $sueldoActual < 1000) {
                $tipoDetectado = 'Probablemente por hora';
                $estado = '🟠 CORREGIR';
            } elseif ($sueldoActual >= 100 && $sueldoActual < 1000 && $totalHoras == 0) {
                $tipoDetectado = 'Probablemente por día';
                $estado = '🟠 CORREGIR';
            } elseif ($sueldoActual < 500) {
                $estado = '🔴 CRÍTICO';
            }

            $rows[] = [
                $plantilla->id,
                $plantilla->oclave ?? 'N/A',
                mb_substr($plantilla->oclave_descripcion ?? 'Sin descripción', 0, 35) . '...',
                number_format($sueldoActual, 2),
                $totalHoras > 0 ? $totalHoras : 'Sin horas',
                $tipoDetectado,
                $estado
            ];
        }

        $this->table($headers, $rows);
        
        if ($problematicos->count() > 30 && !$this->option('fix')) {
            $this->warn("⚠️  Mostrando solo los primeros 30 de {$problematicos->count()} registros.");
            $this->info("💡 Usa --fix para ver todos los registros que se corregirían.");
        }
        $this->newLine();

        // Si es dry-run, mostrar qué se haría
        if ($this->option('dry-run')) {
            $this->info('🔍 MODO DRY-RUN: Mostrando correcciones que se aplicarían:');
            $this->newLine();

            $corregibles = 0;
            $noCorregibles = 0;
            $correcciones = [];

            foreach ($problematicos as $plantilla) {
                $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                             ($plantilla->ohoras_docencia ?? 0) + 
                             ($plantilla->ohoras_compatibilidad ?? 0);
                
                $sueldoActual = $plantilla->omonto_mensual;
                $sueldoCorregido = null;
                $razon = '';
                $puedeCorregir = false;

                if ($totalHoras > 0 && $sueldoActual >= 50 && $sueldoActual < 1000) {
                    // Probablemente es por hora
                    $horasMensuales = $totalHoras * 4.33;
                    $sueldoCorregido = round($sueldoActual * $horasMensuales, 2);
                    $razon = "Por hora: {$sueldoActual} × {$totalHoras} hrs/sem × 4.33 sem/mes";
                    $puedeCorregir = true;
                } elseif ($sueldoActual >= 100 && $sueldoActual < 1000 && $totalHoras == 0) {
                    // Probablemente es por día
                    $sueldoCorregido = round($sueldoActual * 22, 2);
                    $razon = "Por día: {$sueldoActual} × 22 días laborables";
                    $puedeCorregir = true;
                }

                if ($puedeCorregir && $sueldoCorregido) {
                    $correcciones[] = [
                        'clave' => $plantilla->oclave ?? 'N/A',
                        'actual' => $sueldoActual,
                        'corregido' => $sueldoCorregido,
                        'razon' => $razon
                    ];
                    $corregibles++;
                } else {
                    $noCorregibles++;
                }
            }

            if ($corregibles > 0) {
                $this->info("✅ Se pueden corregir automáticamente: {$corregibles} registros");
                $this->newLine();
                
                // Mostrar primeros 20
                foreach (array_slice($correcciones, 0, 20) as $corr) {
                    $this->line("  • {$corr['clave']}: " . 
                               number_format($corr['actual'], 2) . 
                               " → " . 
                               number_format($corr['corregido'], 2) . 
                               " ({$corr['razon']})");
                }
                
                if (count($correcciones) > 20) {
                    $this->warn("  ... y " . (count($correcciones) - 20) . " más");
                }
            }

            if ($noCorregibles > 0) {
                $this->newLine();
                $this->warn("⚠️  {$noCorregibles} registros no se pueden corregir automáticamente (requieren revisión manual)");
            }

            $this->newLine();
            $this->info('💡 Para aplicar las correcciones, ejecuta: php artisan plantilla:verificar-sueldos --fix');
            return 0;
        }

        // Si no es fix, solo mostrar información
        if (!$this->option('fix')) {
            $this->info('💡 Para ver qué se corregiría: php artisan plantilla:verificar-sueldos --dry-run');
            $this->info('💡 Para corregir automáticamente: php artisan plantilla:verificar-sueldos --fix');
            return 0;
        }

        // Modo fix: aplicar correcciones
        $this->warn('⚠️  ADVERTENCIA: Esta operación modificará datos en la base de datos.');
        $this->info('💡 Se recomienda hacer backup antes de continuar.');
        $this->newLine();

        if (!$this->confirm('¿Deseas aplicar las correcciones automáticamente?', false)) {
            $this->info('Operación cancelada.');
            return 0;
        }

        $this->info('🔧 Aplicando correcciones...');
        $this->newLine();

        $corregidos = 0;
        $noCorregidos = 0;
        $errores = 0;

        DB::beginTransaction();
        try {
            foreach ($problematicos as $plantilla) {
                $totalHoras = ($plantilla->ohoras_servicio ?? 0) + 
                             ($plantilla->ohoras_docencia ?? 0) + 
                             ($plantilla->ohoras_compatibilidad ?? 0);
                
                $sueldoActual = $plantilla->omonto_mensual;
                $sueldoCorregido = null;
                $razon = '';

                // Corregir casos según el tipo detectado
                if ($totalHoras > 0 && $sueldoActual > 0 && $sueldoActual < 1000) {
                    // Probablemente es por hora (tiene horas registradas)
                    // Verificar si las horas son semanales o mensuales
                    if ($totalHoras > 40) {
                        // Probablemente las horas son MENSUALES, no semanales
                        $sueldoCorregido = round($sueldoActual * $totalHoras, 2);
                        $razon = "por hora (horas mensuales)";
                    } else {
                        // Horas semanales (≤ 40)
                        $horasMensuales = $totalHoras * 4.33;
                        $sueldoCorregido = round($sueldoActual * $horasMensuales, 2);
                        $razon = "por hora (horas semanales)";
                    }
                } elseif ($sueldoActual > 0 && $sueldoActual < 1000 && $totalHoras == 0) {
                    // Sin horas registradas - determinar si es por día o por hora
                    // Si el valor es muy bajo (< 50), probablemente es por hora
                    // Si el valor es razonable (50-500), podría ser por día
                    if ($sueldoActual < 50) {
                        // Valores muy bajos: probablemente por hora sin horas registradas
                        // Asumir jornada estándar de 40 horas/semana
                        $horasMensuales = 40 * 4.33; // 173.2 horas/mes
                        $sueldoCorregido = round($sueldoActual * $horasMensuales, 2);
                        $razon = "por hora (estimado 40 hrs/sem)";
                    } else {
                        // Valores razonables: probablemente por día
                        $sueldoCorregido = round($sueldoActual * 22, 2);
                        $razon = "por día";
                    }
                }

                // Validar que el sueldo corregido sea razonable
                // Mínimo 1,000 para valores que se corrigieron, pero permitir valores más bajos si son razonables
                if ($sueldoCorregido && $sueldoCorregido > $sueldoActual) {
                    // Si el sueldo corregido es >= 1,000, es definitivamente correcto
                    // Si es < 1,000 pero > 500 y el original era muy bajo (< 10), también corregir
                    $esValido = ($sueldoCorregido >= 1000) || 
                               ($sueldoCorregido >= 500 && $sueldoActual < 10);
                    
                    if ($esValido) {
                        $plantilla->omonto_mensual = $sueldoCorregido;
                        $plantilla->save();
                        $corregidos++;
                        
                        if ($corregidos <= 20) {
                            $this->line("  ✅ {$plantilla->oclave}: " . 
                                       number_format($sueldoActual, 2) . 
                                       " → " . 
                                       number_format($sueldoCorregido, 2) . 
                                       " ({$razon})");
                        }
                    } else {
                        $noCorregidos++;
                    }
                } else {
                    $noCorregidos++;
                }
            }

            DB::commit();

            $this->newLine();
            $this->info("✅ Se corrigieron {$corregidos} registros exitosamente.");
            
            if ($noCorregidos > 0) {
                $this->warn("⚠️  {$noCorregidos} registros no se corrigieron (requieren revisión manual).");
            }

            $this->newLine();
            $this->info('💡 Revisa los resultados y verifica que sean correctos.');
            $this->info('💡 Puedes ejecutar el comando nuevamente para verificar los cambios.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error al aplicar correcciones: " . $e->getMessage());
            $this->error("   Se revirtieron todos los cambios.");
            return 1;
        }

        return 0;
    }
}

