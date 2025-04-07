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
        'text' => 'Revisar E-R',
        'url'  => 'entregas-recepcion',
        'icon' => 'fas fa-clipboard-check',
    ]);

    $event->menu->add([
        'text' => 'Finalizadas',
        'url'  => 'entregas-finalizadas',
        'icon' => 'fas fa-check-circle',
    ]);

    $event->menu->add([
        'text' => 'Histórico',
        'url'  => 'historico-entregas-recepcion',
        'icon' => 'fas fa-history',
    ]);

    $event->menu->add([
        'text' => 'Centros de trabajo',
        'url'  => 'centros-de-trabajo',
        'icon' => 'fas fa-school',
    ]);

    $event->menu->add([
        'text' => 'Usuarios por nivel',
        'icon' => 'fas fa-users-cog',
        'submenu' => [
            [
                'text' => 'Subdirecciones',
                'url' => 'usuarios-subdireccion',
            ],
            [
                'text' => 'Departamentos',
                'url' => 'usuarios-departamento',
            ],
            [
                'text' => 'Sectores',
                'url' => 'usuarios-sector',
            ],
            [
                'text' => 'Supervisiones',
                'url' => 'usuarios-supervision',
            ],
        ],
    ]);

    $event->menu->add([
        'text' => 'Reportes',
        'url'  => 'reportes-mensuales',
        'icon' => 'fas fa-chart-line',
    ]);
}

    
            // Menú para el ADMINISTRADOR PRINCIPAL
            if ($user->orol == 1) {
                $event->menu->add([
                    'header' => 'ADMINISTRACIÓN',
                ]);

                $event->menu->add([
                    'text' => 'Usuarios',
                    'url'  => 'usuarios',
                    'icon' => 'fas fa-user',
                ]);

                $event->menu->add([
                    'text' => 'Roles',
                    'url'  => 'roles',
                    'icon' => 'fas fa-user-shield',
                ]);
            }
    
            // Menú para el USUARIO ENTREGADOR (orol == 3)
            if ($user->orol == 3) {
                $event->menu->add([
                    'header' => 'MI CENTRO',
                ]);

                $event->menu->add([
                    'text' => 'Mis entregas',
                    'url'  => 'entrega-recepcion',
                    'icon' => 'fas fa-file-signature',
                ]);
                $event->menu->add([
                    'text' => 'Mi historial',
                    'url'  => 'historico-entregas-recepcion',
                    'icon' => 'fas fa-archive',
                ]);
            }
        });
    }
}


