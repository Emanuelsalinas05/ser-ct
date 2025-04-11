<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AdminMenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $user = Auth::user();

            if (!$user) return;

            // Menú general visible a todos los roles
            $event->menu->add(
                [
                    'type'         => 'navbar-search',
                    'text'         => 'Buscar',
                    'topnav_right' => true,
                ],
                [
                    'type'         => 'fullscreen-widget',
                    'topnav_right' => true,
                ],
                [
                    'type' => 'sidebar-menu-search',
                    'text' => 'Buscar',
                ]
            );

            // Menú para el ROL 2: REVISOR DE ENTREGA-RECEPCIÓN
            if ($user->orol == 2) {
                $event->menu->add([
                    'header' => 'REVISIÓN',
                ]);

                $event->menu->add([
                    'text' => 'Entregas Recepción',
                    'url'  => 'entregas-recepcion',
                    'icon' => 'fas fa-clipboard-check',
                    'classes' => 'bg-primary text-white fw-bold',
                    'active' => ['entregas-recepcion*'],
                ]);

                $event->menu->add([
                    'text' => 'E-R Finalizadas',
                    'url'  => 'entregas-finalizadas',
                    'icon' => 'fas fa-check-circle',
                    'classes' => 'bg-primary text-white fw-bold',
                    'active' => ['entregas-finalizadas*'],
                ]);

                $event->menu->add([
                    'text' => 'Histórico',
                    'url'  => 'historico-entregas-recepcion',
                    'icon' => 'fas fa-history',
                    'classes' => 'bg-primary text-white fw-bold',
                    'active' => ['historico-entregas-recepcion*'],
                ]);

                $event->menu->add([
                    'text' => 'Usuarios CT',
                    'url'  => 'usuarios',
                    'icon' => 'fas fa-school',
                    'classes' => 'bg-success text-white fw-bold',
                    'active' => ['usuarios*'],
                ]);

                $event->menu->add([
                    'text' => 'Reportes',
                    'url'  => 'reportes-mensuales',
                    'icon' => 'fas fa-chart-line',
                    'classes' => 'bg-danger text-white fw-bold',
                    'active' => ['reportes-mensuales*'],
                ]);
            }

            // Menú para el ADMINISTRADOR PRINCIPAL
            if ($user->orol == 1) {
                $event->menu->add([
                    'text'    => 'Entregas - Recepción',
                    'icon'    => 'fas fa-file-alt',
                    'classes' => 'bg-primary text-white fw-bold',
                    'submenu' => [
                        ['text' => 'En curso', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-hourglass-half', 'active' => ['entregas-recepcion*']],
                        ['text' => 'Finalizadas', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
                        ['text' => 'Históricas', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-archive', 'active' => ['historico-entregas-recepcion*']],
                    ],
                ]);

                $event->menu->add([
                    'text'    => 'Intervención',
                    'icon'    => 'fas fa-toolbox',
                    'classes' => 'bg-warning text-white fw-bold',
                    'submenu' => [
                        ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
                        ['text' => 'Reportes de intervención', 'url' => 'reportes-intervencion', 'icon' => 'fas fa-chart-pie', 'active' => ['reportes-intervencion*']],
                        ['text' => 'Intervención DEE', 'url' => 'intervenciones-niveles', 'icon' => 'fas fa-university', 'active' => ['intervenciones-niveles*']],
                        ['text' => 'Información por niveles', 'url' => 'informacion-niveles', 'icon' => 'fas fa-info-circle', 'active' => ['informacion-niveles*']],
                    ],
                ]);

                $event->menu->add([
                    'text'    => 'Reportes',
                    'icon'    => 'fas fa-chart-line',
                    'classes' => 'bg-danger text-white fw-bold',
                    'submenu' => [
                        ['text' => 'Reportes mensuales', 'url' => 'reportes-mensuales', 'icon' => 'fas fa-calendar-alt', 'active' => ['reportes-mensuales*']],
                        ['text' => 'Exportar datos', 'url' => 'file-export', 'icon' => 'fas fa-file-export', 'active' => ['file-export*']],
                    ],
                ]);

                $event->menu->add([
                    'text'    => 'Certificados No Adeudo',
                    'icon'    => 'fas fa-certificate',
                    'classes' => 'bg-info text-white fw-bold',
                    'submenu' => [
                        ['text' => 'Solicitudes Recibidas', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-inbox', 'active' => ['ver-solicitudes-noadeudos*']],
                        ['text' => 'Solicitudes Aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up', 'active' => ['solicitudes-noadeudos*']],
                        ['text' => 'Gestión CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks', 'active' => ['gestion-noadeudos*']],
                        ['text' => 'CNA Emitidos', 'url' => 'certificados-emitidos', 'icon' => 'fas fa-paper-plane', 'active' => ['certificados-emitidos*']],
                        ['text' => 'CNA Liberados', 'url' => 'certificados-liberados', 'icon' => 'fas fa-unlock-alt', 'active' => ['certificados-liberados*']],
                    ],
                ]);

                $event->menu->add([
                    'text'    => 'Estructura CT',
                    'icon'    => 'fas fa-sitemap',
                    'classes' => 'bg-secondary text-white fw-bold',
                    'submenu' => [
                        ['text' => 'Estructura Elemental', 'url' => 'estructura-elemental', 'icon' => 'fas fa-school', 'active' => ['estructura-elemental*']],
                        ['text' => 'Estructura DESySA', 'url' => 'estructura-desysa', 'icon' => 'fas fa-project-diagram', 'active' => ['estructura-desysa*']],
                    ],
                ]);

                $event->menu->add([
                    'text'    => 'Usuarios / Perfiles',
                    'icon'    => 'fas fa-users-cog',
                    'classes' => 'bg-success text-white fw-bold',
                    'submenu' => [
                        ['text' => 'Usuarios', 'url' => 'usuarios', 'icon' => 'fas fa-user', 'active' => ['usuarios*']],
                        ['text' => 'Centros de Trabajo', 'url' => 'usuarios-levels', 'icon' => 'fas fa-building', 'active' => ['usuarios-levels*']],
                        ['text' => 'Subdirección', 'url' => 'usuarios-subdireccion', 'icon' => 'fas fa-user-tie', 'active' => ['usuarios-subdireccion*']],
                        ['text' => 'Departamento', 'url' => 'usuarios-departamento', 'icon' => 'fas fa-users', 'active' => ['usuarios-departamento*']],
                        ['text' => 'Sector', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired', 'active' => ['usuarios-sector*']],
                        ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                    ],
                ]);
            }

            // Menú para el USUARIO ENTREGADOR (orol == 3)
            if ($user->orol == 3) {
                $event->menu->add([
                    'text' => 'Datos del C.T.',
                    'url'  => 'centro-trabajo',
                    'icon' => 'fas fa-school',
                    'classes' => 'bg-primary text-white fw-bold',
                    'active' => ['centro-trabajo*'],
                ]);
                $event->menu->add([
                    'text' => 'Entrega Recepción',
                    'url'  => 'entrega-recepcion',
                    'icon' => 'fas fa-file-signature',
                    'classes' => 'bg-primary text-white fw-bold',
                    'active' => ['entrega-recepcion*'],
                ]);
                $event->menu->add([
                    'text' => 'Solicitudes',
                    'icon' => 'fas fa-envelope-open-text',
                    'submenu' => [
                        [
                            'text' => 'Certificado de no adeudo',
                            'url'  => 'solicitud-certificado',
                            'icon' => 'far fa-file',
                            'active' => ['solicitud-certificado*'],
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => '1. MARCO JURÍDICO',
                    'url'  => 'marco-juridico',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['marco-juridico*'],
                ]);
                $event->menu->add([
                    'text' => '5. RECURSOS HUMANOS',
                    'url'  => 'recursos-humanos',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['recursos-humanos*', 'plantilla-personal*', 'plantilla-comisionados*'],
                ]);
                $event->menu->add([
                    'text' => '8. SITUACIÓN DE LOS RECURSOS MATERIALES',
                    'url'  => 'situacion-recursos-materiales',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['situacion-recursos-materiales*', 'inventario-bienes*', 'inventario-almacen*', 'relacion-bienes-custodia*'],
                ]);
                $event->menu->add([
                    'text' => '9. SITUACIÓN DE LAS TIC´S',
                    'url'  => 'situacion-tics',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['situacion-tics*', 'inventario-equipo*'],
                ]);
                $event->menu->add([
                    'text' => '13. ARCHIVOS',
                    'url'  => 'archivos',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['archivos*', 'relacion-archivos*', 'relacion-archivos-historico*', 'documentos-noconvencionles*'],
                ]);
                $event->menu->add([
                    'text' => '14. CERTIFICADOS DE NO ADEUDO',
                    'url'  => 'certificados-no-adeudos',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['certificados-no-adeudos*', 'certificados-no-adeudo*'],
                ]);
                $event->menu->add([
                    'text' => '15. INFORME DE GESTIÓN',
                    'url'  => 'informe-gestion',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['informe-gestion*', 'informe-gestion-plantilla*', 'informe-compromisos*'],
                ]);
                $event->menu->add([
                    'text' => '18. OTROS HECHOS',
                    'url'  => 'otroshechos',
                    'icon' => 'far fa-file-alt',
                    'classes' => 'bg-warning text-white fw-bold',
                    'active' => ['otroshechos*', 'otros-hechos*'],
                ]);
                $event->menu->add([
                    'text' => 'Entregas Realizadas',
                    'url'  => 'historico-entregas-recepcion',
                    'icon' => 'fas fa-check-circle',
                    'classes' => 'bg-success text-white fw-bold',
                    'active' => ['historico-entregas-recepcion*'],
                ]);
            }

            if ($user->orol == 99) {
                $event->menu->add([
                    'header' => 'COORDINACIÓN ACADÉMICA',
                ]);

                $event->menu->add([
                    'text' => 'Ver solicitudes CNA',
                    'url'  => 'ver-solicitudes-noadeudos',
                    'icon' => 'fas fa-envelope-open-text',
                    'classes' => 'bg-info text-white fw-bold',
                    'active' => ['ver-solicitudes-noadeudos*'],
                ]);

                $event->menu->add([
                    'text' => 'Solicitudes aprobadas',
                    'url'  => 'solicitudes-noadeudos',
                    'icon' => 'fas fa-file-alt',
                    'classes' => 'bg-info text-white fw-bold',
                    'active' => ['solicitudes-noadeudos*'],
                ]);
            }

        });
    }
}