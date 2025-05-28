<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CentrosTrabajo;
use App\Models\User;

class RepararCCTsCommand extends Command
{
    protected $signature = 'reparar:ccts';
    protected $description = 'Repara CCTs sin usuario ni entrada en g1organigrama';

    public function handle()
    {
        $ccts = CentrosTrabajo::all();

        foreach ($ccts as $ct) {
            $userExists = DB::table('users')->where('id_ct', $ct->kcvect)->exists();
            $orgaExists = DB::table('g1organigrama')->where('idct_escuela', $ct->kcvect)->exists();

            if (!$userExists) {
                $password = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

                DB::table('users')->insert([
                    'name'        => $ct->onombre_ct,
                    'orfc'        => null,
                    'ocurp'       => null,
                    'id_ct'       => $ct->kcvect,
                    'oct'         => $ct->oclave,
                    'email'       => $ct->oclave,
                    'password'    => Hash::make($password),
                    'opwd'        => $password,
                    'orol'        => 3,
                    'ocorreo'     => null,
                    'onivel'      => $ct->odireccion,
                    'id_ctorigen' => 1, // puedes ajustar según tu lógica
                    'octorigen'   => 'admin@seiem.gob.mx',
                    'ocargo'      => 'ESCUELA',
                    'ovalle'      => $ct->ovalle,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                $this->info("🟢 Usuario creado para CCT: {$ct->oclave}");
            }

            if (!$orgaExists) {
                DB::table('g1organigrama')->insert([
                    'idct_escuela'    => $ct->kcvect,
                    'cct_escuela'     => $ct->oclave,
                    'odireccionnivel' => $ct->onamedir,
                    'cct_direccion'   => 'admin@seiem.gob.mx',
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                $this->info("🔵 Organigrama creado para CCT: {$ct->oclave}");
            }
        }

        $this->info("✅ Reparación de CCTs completada.");
    }
}
