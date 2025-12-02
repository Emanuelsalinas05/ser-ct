<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Ordenamientojuridico;
use App\Models\DatosActa;

class ActualizarIdActaOrdenamientoJuridico extends Command
{
    protected $signature = 'ordenamiento:actualizar-id-acta {--fix : Aplicar actualizaciones}';
    protected $description = 'Actualiza el campo id_acta en registros existentes de ordenamiento jurídico';

    public function handle()
    {
        $this->info('🔍 Actualizando id_acta en ordenamientos jurídicos existentes...');
        $this->newLine();

        // Obtener registros sin id_acta
        $sinIdActa = Ordenamientojuridico::whereNull('id_acta')
            ->orWhere('id_acta', 0)
            ->get();

        if ($sinIdActa->isEmpty()) {
            $this->info('✅ Todos los registros ya tienen id_acta asignado.');
            return 0;
        }

        $this->warn("⚠️  Se encontraron {$sinIdActa->count()} registros sin id_acta");
        $this->newLine();

        $actualizados = 0;
        $noActualizados = 0;

        foreach ($sinIdActa as $registro) {
            // Buscar la acta más reciente no concluida del mismo centro de trabajo
            // Si no hay, buscar la más reciente concluida
            $acta = DatosActa::where('id_ct', $registro->id_ct)
                ->where('oconcluida', 0)
                ->orderBy('created_at', 'DESC')
                ->first();

            if (!$acta) {
                $acta = DatosActa::where('id_ct', $registro->id_ct)
                    ->orderBy('created_at', 'DESC')
                    ->first();
            }

            if ($acta) {
                if ($this->option('fix')) {
                    $registro->id_acta = $acta->id;
                    $registro->save();
                    $actualizados++;
                    
                    if ($actualizados <= 20) {
                        $this->line("  ✅ ID {$registro->id}: Asignado a acta {$acta->id}");
                    }
                } else {
                    $this->line("  • ID {$registro->id}: Se asignaría a acta {$acta->id}");
                    $actualizados++;
                }
            } else {
                $noActualizados++;
                $this->warn("  ⚠️  ID {$registro->id}: No se encontró acta para el centro de trabajo {$registro->id_ct}");
            }
        }

        $this->newLine();
        
        if ($this->option('fix')) {
            $this->info("✅ Se actualizaron {$actualizados} registros.");
            if ($noActualizados > 0) {
                $this->warn("⚠️  {$noActualizados} registros no se pudieron actualizar (no tienen acta asociada).");
            }
        } else {
            $this->info("📋 Se pueden actualizar {$actualizados} registros.");
            $this->info("💡 Para aplicar: php artisan ordenamiento:actualizar-id-acta --fix");
        }

        return 0;
    }
}

