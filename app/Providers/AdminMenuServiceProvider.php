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

            // Menú general para todos los roles
            $event->menu->add(
                ['type' => 'navbar-search', 'text' => 'Buscar', 'topnav_right' => true],
                ['type' => 'fullscreen-widget', 'topnav_right' => true],
                ['type' => 'sidebar-menu-search', 'text' => 'Buscar']
            );

            // Menú según el rol
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
            'text' => 'Entregas - Recepción', 'icon' => 'fas fa-file-alt', 'classes' => self::MENU_PRIMARY,
            'submenu' => [
                ['text' => 'En curso', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-hourglass-half', 'active' => ['entregas-recepcion*']],
                ['text' => 'Finalizadas', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
                ['text' => 'Históricas', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-archive', 'active' => ['historico-entregas-recepcion*']],
            ],
        ]);

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => [
                ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
                ['text' => 'Reportes de intervención', 'url' => 'reportes-intervencion', 'icon' => 'fas fa-chart-pie', 'active' => ['reportes-intervencion*']],
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
                ['text' => 'Exportar datos', 'url' => 'file-export', 'icon' => 'fas fa-file-export', 'active' => ['file-export*']],
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
                ['text' => 'Históricas', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-archive', 'active' => ['historico-entregas-recepcion*']],
            ],
        ]);

        $this->addCertificadosMenu($event, $user);

        $event->menu->add([
            'text' => 'Usuarios por CT',
            'icon' => 'fas fa-school',
            'classes' => self::MENU_SUCCESS,
            'url' => '#',
            'submenu' => [
                ['text' => 'Ver Usuarios', 'url' => 'usuarios?origen=' . $idOrigen, 'icon' => 'fas fa-user-friends', 'active' => ['usuarios*']]
            ]
        ]);

        $event->menu->add([
            'text' => 'Reportes',
            'url' => 'reportes-mensuales',
            'icon' => 'fas fa-chart-line',
            'classes' => self::MENU_DANGER,
            'active' => ['reportes-mensuales*']
        ]);
    }

    private function buildEntregadorMenu(BuildingMenu $event, $user)
    {
        $solicitudGenerada = Solicitudnoadeudo::where('id_ct', $user->id_ct)
            ->where('ogenerado', 1)
            ->first();

        $event->menu->add(
            ['text' => 'Datos del C.T.', 'url' => 'centro-trabajo', 'icon' => 'fas fa-school', 'classes' => self::MENU_PRIMARY, 'active' => ['centro-trabajo*']],
            ['text' => 'Entrega Recepción', 'url' => 'entrega-recepcion', 'icon' => 'fas fa-file-signature', 'classes' => self::MENU_PRIMARY, 'active' => ['entrega-recepcion*']],
            ['text' => 'Solicitudes', 'icon' => 'fas fa-envelope-open-text', 'submenu' => [
                ['text' => 'Certificado de no adeudo', 'url' => 'solicitud-certificado', 'icon' => 'far fa-file', 'active' => ['solicitud-certificado*']]
            ]]
        );

        if ($solicitudGenerada) {
            $event->menu->add(
                ['text' => '1. MARCO JURÍDICO', 'url' => 'marco-juridico', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['marco-juridico*']],
                ['text' => '5. RECURSOS HUMANOS', 'url' => 'recursos-humanos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['recursos-humanos*', 'plantilla-personal*', 'plantilla-comisionados*']],
                ['text' => '8. SITUACIÓN DE LOS RECURSOS MATERIALES', 'url' => 'situacion-recursos-materiales', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['situacion-recursos-materiales*', 'inventario-bienes*', 'inventario-almacen*', 'relacion-bienes-custodia*']],
                ['text' => '9. SITUACIÓN DE LAS TIC´S', 'url' => 'situacion-tics', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['situacion-tics*', 'inventario-equipo*']],
                ['text' => '13. ARCHIVOS', 'url' => 'archivos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['archivos*', 'relacion-archivos*', 'relacion-archivos-historico*', 'documentos-noconvencionles*']],
                ['text' => '14. CERTIFICADOS DE NO ADEUDO', 'url' => 'certificados-no-adeudos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['certificados-no-adeudos*', 'certificados-no-adeudo*']],
                ['text' => '15. INFORME DE GESTIÓN', 'url' => 'informe-gestion', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['informe-gestion*', 'informe-gestion-plantilla*', 'informe-compromisos*']],
                ['text' => '18. OTROS HECHOS (Generales)', 'url' => 'otroshechos', 'icon' => 'far fa-file-alt', 'classes' => self::MENU_WARNING, 'active' => ['otroshechos*', 'otros-hechos*']],
                ['text' => 'Entregas Realizadas', 'url' => 'historico-entregas-recepcion', 'icon' => 'fas fa-check-circle', 'classes' => self::MENU_SUCCESS, 'active' => ['historico-entregas-recepcion*']]
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
            ['text' => 'Solicitudes Recibidas', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-inbox', 'active' => ['ver-solicitudes-noadeudos*']],
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
        $event->menu->add([
            'text' => 'Usuarios / Perfiles',
            'icon' => 'fas fa-users-cog',
            'classes' => self::MENU_SUCCESS,
            'submenu' => [
                ['text' => 'Dirección', 'url' => 'usuarios-levels', 'icon' => 'fas fa-sitemap', 'active' => ['usuarios-levels*']],
                ['text' => 'Subdirección', 'url' => 'usuarios-subdireccion', 'icon' => 'fas fa-user-tie', 'active' => ['usuarios-subdireccion*']],
                ['text' => 'Departamento', 'url' => 'usuarios-departamento', 'icon' => 'fas fa-users', 'active' => ['usuarios-departamento*']],
                ['text' => 'Sector', 'url' => 'usuarios-sector', 'icon' => 'fas fa-network-wired', 'active' => ['usuarios-sector*']],
                ['text' => 'Supervisión', 'url' => 'usuarios-supervision', 'icon' => 'fas fa-user-check', 'active' => ['usuarios-supervision*']],
                ['text' => 'Centros de Trabajo', 'url' => 'centros-de-trabajo', 'icon' => 'fas fa-building', 'active' => ['centros-de-trabajo*']],
            ],
        ]);
    }
}
