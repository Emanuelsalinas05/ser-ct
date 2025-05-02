<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Solicitudnoadeudo;

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

            // Menú superior (buscadores y fullscreen)
            $event->menu->add(
                ['type' => 'navbar-search', 'text' => 'BUSCAR', 'topnav_right' => true],
                ['type' => 'fullscreen-widget', 'topnav_right' => true],
                ['type' => 'sidebar-menu-search', 'text' => 'BUSCAR']
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
        $menus = [
            [
                'text' => 'ENTREGAS - RECEPCIÓN',
                'icon' => 'fas fa-file-alt',
                'classes' => self::MENU_PRIMARY,
                'submenu' => [
                    ['text' => 'EN CURSO', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-hourglass-half', 'active' => ['entregas-recepcion*']],
                    ['text' => 'FINALIZADAS', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
                    ['text' => 'HISTÓRICAS', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-archive', 'active' => ['historico-entregas-recepcion*']],
                ],
            ],
            [
                'text' => 'INTERVENCIÓN',
                'icon' => 'fas fa-toolbox',
                'classes' => self::MENU_WARNING,
                'submenu' => [
                    ['text' => 'SOLICITUD DE INTERVENCIÓN', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
                    ['text' => 'REPORTES DE INTERVENCIÓN', 'url' => 'reportes-intervencion', 'icon' => 'fas fa-chart-pie', 'active' => ['reportes-intervencion*']],
                    ['text' => 'INTERVENCIÓN DEE', 'url' => 'intervenciones-niveles', 'icon' => 'fas fa-university', 'active' => ['intervenciones-niveles*']],
                    ['text' => 'INFORMACIÓN POR NIVELES', 'url' => 'informacion-niveles', 'icon' => 'fas fa-info-circle', 'active' => ['informacion-niveles*']],
                ],
            ],
            [
                'text' => 'REPORTES',
                'icon' => 'fas fa-chart-line',
                'classes' => self::MENU_DANGER,
                'submenu' => [
                    ['text' => 'REPORTES MENSUALES', 'url' => 'reportes-mensuales', 'icon' => 'fas fa-calendar-alt', 'active' => ['reportes-mensuales*']],
                    ['text' => 'EXPORTAR DATOS', 'url' => 'file-export', 'icon' => 'fas fa-file-export', 'active' => ['file-export*']],
                ],
            ],
        ];

        $event->menu->add(...$menus);

        $this->addCertificadosMenu($event, $user);
        $this->addUsuariosMenu($event);
    }

    private function buildRevisorMenu(BuildingMenu $event, $user)
    {
        $idOrigen = $user->id_ctorigen;

        $menus = [
            [
                'text' => 'ENTREGAS RECEPCIÓN',
                'icon' => 'fas fa-clipboard-check',
                'classes' => self::MENU_PRIMARY,
                'submenu' => [
                    ['text' => 'EN CURSO', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-folder-open', 'active' => ['entregas-recepcion*']],
                    ['text' => 'FINALIZADAS', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
                    ['text' => 'HISTÓRICAS', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-archive', 'active' => ['historico-entregas-recepcion*']],
                ],
            ],
            [
                'text' => 'USUARIOS POR CT',
                'icon' => 'fas fa-school',
                'classes' => self::MENU_SUCCESS,
                'submenu' => [
                    ['text' => 'VER USUARIOS', 'url' => 'usuarios?origen=' . $idOrigen, 'icon' => 'fas fa-user-friends', 'active' => ['usuarios*']],
                ],
            ],
            [
                'text' => 'REPORTES',
                'url' => 'reportes-mensuales',
                'icon' => 'fas fa-chart-line',
                'classes' => self::MENU_DANGER,
                'active' => ['reportes-mensuales*'],
            ],
        ];

        $event->menu->add(...$menus);

        $this->addCertificadosMenu($event, $user);
    }

    private function buildEntregadorMenu(BuildingMenu $event, $user)
    {
        $menus = [
            [
                'text' => 'ENTREGA RECEPCIÓN',
                'url' => 'entrega-recepcion',
                'icon' => 'fas fa-file-signature',
                'classes' => self::MENU_PRIMARY,
                'active' => ['entrega-recepcion*'],
            ],
            [
                'text' => 'SOLICITUDES',
                'icon' => 'fas fa-envelope-open-text',
                'submenu' => [
                    ['text' => 'CERTIFICADO DE NO ADEUDO', 'url' => 'solicitud-certificado', 'icon' => 'far fa-file', 'active' => ['solicitud-certificado*']],
                ],
            ],
        ];

        // Si el entregador ya generó solicitud, agregamos más menús
        $solicitudGenerada = Solicitudnoadeudo::where('id_ct', $user->id_ct)
            ->where('ogenerado', 1)
            ->first();

        if ($solicitudGenerada) {
            $menus = array_merge($menus, [
                ['text' => '1. MARCO JURÍDICO', 'url' => 'marco-juridico', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['marco-juridico*']],
                ['text' => '5. RECURSOS HUMANOS', 'url' => 'recursos-humanos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['recursos-humanos*', 'plantilla-personal*', 'plantilla-comisionados*']],
                ['text' => '8. SITUACIÓN DE LOS RECURSOS MATERIALES', 'url' => 'situacion-recursos-materiales', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['situacion-recursos-materiales*']],
                ['text' => '9. SITUACIÓN DE LAS TIC´S', 'url' => 'situacion-tics', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['situacion-tics*']],
                ['text' => '13. ARCHIVOS', 'url' => 'archivos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['archivos*']],
                ['text' => '14. CERTIFICADOS DE NO ADEUDO', 'url' => 'certificados-no-adeudos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING],
                ['text' => '15. INFORME DE GESTIÓN', 'url' => 'informe-gestion', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING],
                ['text' => '18. OTROS HECHOS (GENERALES)', 'url' => 'otroshechos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING],
                ['text' => 'ENTREGAS REALIZADAS', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-check-circle', 'classes' => self::MENU_SUCCESS],
            ]);
        }

        $event->menu->add(...$menus);
    }

    private function buildCoordinadorMenu(BuildingMenu $event)
    {
        $menus = [
            ['text' => 'VER SOLICITUDES CNA', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-envelope-open-text', 'classes' => self::MENU_INFO],
            ['text' => 'SOLICITUDES APROBADAS', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-file-alt', 'classes' => self::MENU_INFO],
        ];

        $event->menu->add(...$menus);
    }

    private function addCertificadosMenu(BuildingMenu $event, $user)
    {
        $submenu = [
            ['text' => 'SOLICITUDES RECIBIDAS', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-inbox'],
            ['text' => 'SOLICITUDES APROBADAS', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up'],
        ];

        if (in_array($user->orol, [1, 99])) {
            $submenu[] = ['text' => 'GESTIÓN CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks'];
            $submenu[] = ['text' => 'CNA EMITIDOS', 'url' => 'certificados-emitidos', 'icon' => 'fas fa-paper-plane'];
            $submenu[] = ['text' => 'CNA LIBERADOS', 'url' => 'certificados-liberados', 'icon' => 'fas fa-unlock-alt'];
        }

        $event->menu->add([
            'text' => 'CERTIFICADOS NO ADEUDO',
            'icon' => 'fas fa-certificate',
            'classes' => self::MENU_INFO,
            'submenu' => $submenu,
        ]);
    }

    private function addUsuariosMenu(BuildingMenu $event)
    {
        $event->menu->add([
            'text' => 'USUARIOS / PERFILES',
            'icon' => 'fas fa-users-cog',
            'classes' => self::MENU_SUCCESS,
            'submenu' => [
                ['text' => 'DIRECCIÓN', 'url' => 'usuarios-levels', 'icon' => 'fas fa-sitemap'],
                ['text' => 'SUBDIRECCIÓN', 'url' => 'usuarios-subdireccion', 'icon' => 'fas fa-user-tie'],
                ['text' => 'DEPARTAMENTO', 'url' => 'usuarios-departamento', 'icon' => 'fas fa-users'],
                ['text' => 'SECTOR', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired'],
                ['text' => 'SUPERVISIÓN', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check'],
                ['text' => 'CENTROS DE TRABAJO', 'url' => 'centros-de-trabajo', 'icon' => 'fas fa-building'],
            ],
        ]);
    }
}
