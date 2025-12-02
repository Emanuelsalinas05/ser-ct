<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Plantillapersonal;
use App\Models\Plantilla;

class CorregirSueldosPlantillaPersonal extends Command
{
    protected $signature = 'plantilla:corregir-personal 
                            {--fix : Corregir automáticamente los valores}
                            {--dry-run : Solo mostrar qué se corregiría}';

    protected $description = 'Corrige sueldos incorrectos en la tabla g1plantilla_personal basándose en g1claves_plantilla';

    public function handle()
    {
        $this->info('🔍 Verificando sueldos en g1plantilla_personal...');
        $this->newLine();

        // Obtener registros de plantilla_personal con sueldos sospechosamente bajos
        $problematicos = Plantillapersonal::where('osueldo_ind', '<', 1000)
            ->where('osueldo_ind', '>', 0)
            ->whereNotIn('status', ['B'])
            ->get();

        if ($problematicos->isEmpty()) {
            $this->info('✅ No se encontraron registros problemáticos.');
            return 0;
        }

        $this->warn("⚠️  Se encontraron {$problematicos->count()} registros con sueldos < 1,000");
        $this->newLine();

        // Obtener los datos correctos de la tabla de origen
        $correcciones = [];
        foreach ($problematicos as $personal) {
            $plantilla = Plantilla::where('oclave', $personal->oclave_puesto)
                ->where('ocm', 0)
                ->first();

            if ($plantilla && $plantilla->omonto_mensual >= 1000) {
                // El valor en la tabla de origen ya está corregido
                $correcciones[] = [
                    'personal' => $personal,
                    'sueldo_actual' => $personal->osueldo_ind,
                    'sueldo_correcto' => $plantilla->omonto_mensual,
                    'sueldo_total_correcto' => $personal->ototalplazas * $plantilla->omonto_mensual
                ];
            }
        }

        if (empty($correcciones)) {
            $this->info('✅ No se encontraron registros que necesiten corrección.');
            $this->info('💡 Los valores en g1claves_plantilla ya están correctos o no hay coincidencias.');
            return 0;
        }

        $this->info("📋 Se pueden corregir " . count($correcciones) . " registros:");
        $this->newLine();

        $headers = ['ID', 'Clave', 'Sueldo Actual', 'Sueldo Correcto', 'Total Actual', 'Total Correcto'];
        $rows = [];

        foreach (array_slice($correcciones, 0, 20) as $corr) {
            $rows[] = [
                $corr['personal']->id,
                $corr['personal']->oclave_puesto,
                number_format($corr['sueldo_actual'], 2),
                number_format($corr['sueldo_correcto'], 2),
                number_format($corr['personal']->osueldo_total, 2),
                number_format($corr['sueldo_total_correcto'], 2)
            ];
        }

        $this->table($headers, $rows);

        if (count($correcciones) > 20) {
            $this->warn("... y " . (count($correcciones) - 20) . " más");
        }

        $this->newLine();

        if ($this->option('dry-run')) {
            $this->info('💡 Para aplicar las correcciones: php artisan plantilla:corregir-personal --fix');
            return 0;
        }

        if (!$this->option('fix')) {
            $this->info('💡 Para ver qué se corregiría: php artisan plantilla:corregir-personal --dry-run');
            $this->info('💡 Para corregir: php artisan plantilla:corregir-personal --fix');
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
                $corr['personal']->osueldo_ind = $corr['sueldo_correcto'];
                $corr['personal']->osueldo_total = $corr['sueldo_total_correcto'];
                $corr['personal']->save();
                $corregidos++;

                if ($corregidos <= 20) {
                    $this->line("  ✅ {$corr['personal']->oclave_puesto}: " . 
                               number_format($corr['sueldo_actual'], 2) . 
                               " → " . 
                               number_format($corr['sueldo_correcto'], 2));
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

