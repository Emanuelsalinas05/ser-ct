<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Intervencion;

class AdminMenuServiceProvider extends ServiceProvider
{
    private const MENU_PRIMARY = 'bg-primary text-white fw-bold';
    private const MENU_WARNING = 'bg-warning text-white fw-bold';
    private const MENU_SUCCESS = 'bg-success text-white fw-bold';
    private const MENU_DANGER  = 'bg-danger text-white fw-bold';
    private const MENU_INFO    = 'bg-info text-white fw-bold';

    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = Auth::user();

            if (!$user || !isset($user->orol)) return;

            $event->menu->add(
                ['type' => 'navbar-search', 'text' => 'Buscar', 'topnav_right' => true],
                ['type' => 'fullscreen-widget', 'topnav_right' => true],
                ['type' => 'sidebar-menu-search', 'text' => 'Buscar']
            );

            match ($user->orol) {
                1 => $this->buildAdminMenu($event, $user),
                2 => $this->buildRevisorMenu($event, $user),
                3 => $this->buildEntregadorMenu($event, $user),
                99 => $this->buildCoordinadorMenu($event),
                default => null,
            };
        });
    }

    private function buildAdminMenu(BuildingMenu $event, $user)
    {
        $event->menu->add([
            'text' => 'Entregas - Recepción',
            'icon' => 'fas fa-file-alt',
            'classes' => self::MENU_PRIMARY,
            'submenu' => [
                [
                    'text' => 'En curso',
                    'url' => 'entregas-recepcion',
                    'icon' => 'fas fa-hourglass-half',
                    'active' => ['entregas-recepcion*'],
                ],
                [
                    'text' => 'Finalizadas',
                    'url' => 'entregas-finalizadas',
                    'icon' => 'fas fa-check-circle',
                    'active' => ['entregas-finalizadas*'],
                ],
            ],
        ]);


        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => [
                ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
                ['text' => 'Intervención DEE', 'url' => 'intervenciones-niveles', 'icon' => 'fas fa-university', 'active' => ['intervenciones-niveles*']],
                ['text' => 'Información por niveles', 'url' => 'informacion-niveles', 'icon' => 'fas fa-info-circle', 'active' => ['informacion-niveles*']],
            ],
        ]);

        $this->addCertificadosMenu($event, $user);
        $this->addUsuariosMenu($event);

        $event->menu->add([
            'text' => 'Reportes', 'icon' => 'fas fa-chart-line', 'classes' => self::MENU_DANGER,
            'submenu' => [
                ['text' => 'Reportes mensuales', 'url' => 'reportes-mensuales', 'icon' => 'fas fa-calendar-alt', 'active' => ['reportes-mensuales*']],
            ],
        ]);
    }

    private function buildRevisorMenu(BuildingMenu $event, $user)
    {
        $idOrigen = $user->id_ctorigen;

        $event->menu->add([
            'text' => 'Entregas Recepción', 'icon' => 'fas fa-clipboard-check', 'classes' => self::MENU_PRIMARY,
            'submenu' => [
                ['text' => 'En Curso', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-folder-open', 'active' => ['entregas-recepcion*']],
                ['text' => 'Finalizadas', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
            ],
        ]);
        $this->addCertificadosMenu($event, $user);

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => [
                ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
            ],
        ]);
        $this->addUsuariosMenu($event);
    }


    private function buildEntregadorMenu(BuildingMenu $event, $user)
    {
        $intervencionGenerada = Intervencion::where('idct_escuela', $user->id_ct)
            ->where('ogenerada', 1)
            ->exists();

        $event->menu->add(
            ['text' => 'Entrega Recepción', 'url' => 'entrega-recepcion', 'icon' => 'fas fa-file-signature', 'classes' => self::MENU_PRIMARY, 'active' => ['entrega-recepcion*']],
        );

        if ($intervencionGenerada) {
            $event->menu->add(
                ['text' => '1. MARCO JURÍDICO', 'url' => 'marco-juridico', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['marco-juridico*']],
                ['text' => '5. RECURSOS HUMANOS', 'url' => 'recursos-humanos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['recursos-humanos*', 'plantilla-personal*', 'plantilla-comisionados*']],
                ['text' => '8. SITUACIÓN DE LOS RECURSOS MATERIALES', 'url' => 'recursos-materiales', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['recursos-materiales*', 'inventario-bienes*', 'inventario-almacen*', 'relacion-bienes-custodia*']],
                ['text' => '9. SITUACIÓN DE LAS TIC´S', 'url' => 'inventario-equipo', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['inventario-equipo*']],
                ['text' => '13. ARCHIVOS', 'url' => 'relacion-archivos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['relacion-archivos*', 'relacion-archivos-historico*', 'documentos-noconvencionles*']],
                ['text' => '18. OTROS HECHOS (GENERALES)', 'url' => 'otros-hechos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['otros-hechos*']],
                ['text' => 'Entregas Realizadas', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'classes' => self::MENU_SUCCESS, 'active' => ['entregas-finalizadas*']],

            );
        }
    }





    private function buildCoordinadorMenu(BuildingMenu $event)
    {
        $event->menu->add(
            ['text' => 'Ver solicitudes CNA', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-envelope-open-text', 'classes' => self::MENU_INFO, 'active' => ['ver-solicitudes-noadeudos*']],
            ['text' => 'Solicitudes aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-file-alt', 'classes' => self::MENU_INFO, 'active' => ['solicitudes-noadeudos*']]
        );
    }

    private function addCertificadosMenu(BuildingMenu $event, $user)
    {
        $submenu = [
            ['text' => 'Solicitudes Aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up', 'active' => ['solicitudes-noadeudos*']],
        ];

        if (in_array($user->orol, [1, 99])) {
            $submenu[] = ['text' => 'Gestión CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks', 'active' => ['gestion-noadeudos*']];
            $submenu[] = ['text' => 'CNA Emitidos', 'url' => 'certificados-emitidos', 'icon' => 'fas fa-paper-plane', 'active' => ['certificados-emitidos*']];
            $submenu[] = ['text' => 'CNA Liberados', 'url' => 'certificados-liberados', 'icon' => 'fas fa-unlock-alt', 'active' => ['certificados-liberados*']];
        }

        $event->menu->add([
            'text' => 'Certificados No Adeudo',
            'icon' => 'fas fa-certificate',
            'classes' => self::MENU_INFO,
            'submenu' => $submenu,
        ]);
    }

    private function addUsuariosMenu(BuildingMenu $event)
    {
        $user = Auth::user();
        $submenu = [];

        // Si es Administrador (rol 1), ve todo
        if ($user->orol == 1 && $user->ocargo === 'DIRECCIÓN') {
            $submenu = [
                ['text' => 'Subdirección', 'url' => 'usuarios-subdireccion', 'icon' => 'fas fa-user-tie', 'active' => ['usuarios-subdireccion*']],
                ['text' => 'Departamento', 'url' => 'usuarios-departamento', 'icon' => 'fas fa-users', 'active' => ['usuarios-departamento*']],
                ['text' => 'Sector', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired', 'active' => ['usuarios-sector*']],
                ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                ['text' => 'Escuelas', 'url' => 'usuarios', 'icon' => 'fas fa-school', 'active' => ['usuarios*']],
            ];
        }

        // Si es Revisor (rol 2), construye menú según su nivel jerárquico
        elseif ($user->orol == 2) {
            switch ($user->ocargo) {
                case 'SUBDIRECCIÓN':
                    $submenu = [
                        ['text' => 'Departamento', 'url' => 'usuarios-departamento', 'icon' => 'fas fa-users', 'active' => ['usuarios-departamento*']],
                        ['text' => 'Sector', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired', 'active' => ['usuarios-sector*']],
                        ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                        ['text' => 'Escuelas', 'url' => 'usuarios', 'icon' => 'fas fa-school', 'active' => ['usuarios*']],
                    ];
                    break;
                case 'DEPARTAMENTO':
                    $submenu = [
                        ['text' => 'Sector', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired', 'active' => ['usuarios-sector*']],
                        ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                        ['text' => 'Escuelas', 'url' => 'usuarios', 'icon' => 'fas fa-school', 'active' => ['usuarios*']],
                    ];
                    break;
                case 'SECTOR':
                    $submenu = [
                        ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                        ['text' => 'Escuelas', 'url' => 'usuarios', 'icon' => 'fas fa-school', 'active' => ['usuarios*']],
                    ];
                    break;
                case 'SUPERVISIÓN':
                    $submenu = [
                        ['text' => 'Escuelas', 'url' => 'usuarios', 'icon' => 'fas fa-school', 'active' => ['usuarios*']],
                    ];
                    break;
            }
        }

        // Agrega el menú si hay contenido
        if (!empty($submenu)) {
            $event->menu->add([
                'text' => 'Usuarios / Perfiles',
                'icon' => 'fas fa-users-cog',
                'classes' => self::MENU_SUCCESS,
                'submenu' => $submenu,
            ]);
        }
    }


}