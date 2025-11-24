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

        // Menú específico para subdirecciones (rol 2)
        if ($user->orol == 2) {
            $event->menu->add([
                'text' => 'Certificados No Adeudo',
                'icon' => 'fas fa-certificate',
                'classes' => self::MENU_INFO,
                'submenu' => [
                    ['text' => 'Ver Solicitudes CNA', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-envelope-open-text', 'active' => ['ver-solicitudes-noadeudos*']],
                    ['text' => 'Gestión CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks', 'active' => ['gestion-noadeudos*']],
                    ['text' => 'Solicitudes Aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up', 'active' => ['solicitudes-noadeudos*']],
                ]
            ]);
        } else {
            $this->addCertificadosMenu($event, $user);
        }

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => [
                ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
            ],
        ]);
        $this->addUsuariosMenu($event);
    }

private function buildEntregadorMenu(BuildingMenu $event, $user): void
{
    // Acceso principal
    $event->menu->add([
        'text'    => 'Entrega Recepción',
        'url'     => 'entrega-recepcion',
        'icon'    => 'fas fa-file-signature',
        'classes' => self::MENU_PRIMARY,
        'active'  => ['entrega-recepcion*'],
    ]);

    // Verificar si hay intervención generada (concluida o no)
    $intervencionExistente = \App\Models\Intervencion::where('idct_escuela', $user->id_ct)
        ->where('ogenerada', 1)
        ->where('istatus', '!=', 'B')
        ->first();
    
    // Si no hay intervención, ocultar menú
    if (!$intervencionExistente) { return; }
    
    // Verificar si tiene un acta NO concluida (en curso) asociada a esta intervención
    // Solo las actas NO concluidas indican un proceso en curso
    // Cada solicitud y entrega es independiente, así que verificamos por intervención específica
    $actaEnCurso = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('id_ct', $user->id_ct)
        ->where('oconcluida', 0) // Solo actas en curso
        ->first();
    
    // Si hay acta en curso, verificar si el proceso está completamente finalizado
    // El proceso está finalizado cuando: ZIP cargado (ocargacomprimido=1) Y correo enviado (oenviocorreooic=1)
    if ($actaEnCurso) {
        $procesoFinalizado = ($actaEnCurso->ocargacomprimido == 1 && 
                             $actaEnCurso->oenviocorreooic == 1);
        
        // Solo ocultar menú si el proceso está completamente finalizado
        // En ese caso, el registro vuelve a "Solicitud de intervención" y se necesita una nueva intervención
        if ($procesoFinalizado) { return; }
        // Si hay acta en curso y el proceso NO está finalizado, mostrar menú (continuar trabajo)
    }
    // Si NO hay acta en curso, mostrar menú (iniciar nueva entrega-recepción)

    // Flags 14 y 15
    $idTipoActa = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('oconcluida', 0)
        ->value('id_tipoacta');
    $mostrar15 = ((int)$idTipoActa === 1);

    $mostrar14 = \App\Models\Solicitudnoadeudo::where('id_ct', $user->id_ct)
        ->where('status', '!=', 'B')
        ->where(fn($q) => $q->whereNull('ofinalizado')->orWhere('ofinalizado', 0))
        ->exists();

    // Módulos
    $items = [
        ['text'=>'Solicitar Certificado','url'=>'solicitud-certificado','icon'=>'fas fa-file-signature','classes'=>self::MENU_INFO,'active'=>['solicitud-certificado*']],

        ['text'=>'1. MARCO JURÍDICO','url'=>'marco-juridico','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['marco-juridico*']],
        ['text'=>'5. RECURSOS HUMANOS','url'=>'recursos-humanos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['recursos-humanos*','plantilla-personal*','plantilla-comisionados*']],
        ['text'=>'8. SITUACIÓN DE LOS RECURSOS MATERIALES','url'=>'recursos-materiales','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['recursos-materiales*','inventario-bienes*','inventario-almacen*','relacion-bienes-custodia*']],
        ['text'=>'9. SITUACIÓN DE LAS TIC´S','url'=>'situacion-tics','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['situacion-tics*','inventario-equipo*']],
        ['text'=>'13. ARCHIVOS','url'=>'archivos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['archivos*','relacion-archivos*','relacion-archivos-historico*','documentos-noconvencionales*']],
    ];

    if ($mostrar14) {
        $items[] = ['text'=>'14. CERTIFICADO DE NO ADEUDO','url'=>'certificados-no-adeudos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['certificados-no-adeudos*','certificados-no-adeudo*']];
    }
    if ($mostrar15) {
        $items[] = ['text'=>'15. INFORME DE GESTIÓN','url'=>'informe-gestion','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['informe-gestion*']];
    }

    $items[] = ['text'=>'18. OTROS HECHOS (GENERALES)','url'=>'otroshechos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['otroshechos*','otros-hechos*']];
    $items[] = ['text'=>'Entregas Realizadas','url'=>'entregas-finalizadas','icon'=>'fas fa-check-circle','classes'=>self::MENU_SUCCESS,'active'=>['entregas-finalizadas*']];

    $event->menu->add(...$items);
}






private function buildCoordinadorMenu(BuildingMenu $event)
{
    $user = auth()->user();

    if ($user->orol == 99) {
        // Menú para super administradores (rol 99) - Coordinación Académica y de Operación Educativa
        $event->menu->add([
            'text' => 'Entregas Recepción', 'icon' => 'fas fa-clipboard-check', 'classes' => self::MENU_PRIMARY,
            'submenu' => [
                ['text' => 'En Curso', 'url' => 'entregas-recepcion', 'icon' => 'fas fa-folder-open', 'active' => ['entregas-recepcion*']],
                ['text' => 'Finalizadas', 'url' => 'entregas-finalizadas', 'icon' => 'fas fa-check-circle', 'active' => ['entregas-finalizadas*']],
            ],
        ]);

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => [
                ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']],
                ['text' => 'Reportes de intervención', 'url' => 'reportes-intervencion', 'icon' => 'fas fa-file-export', 'active' => ['reportes-intervencion*']],
            ],
        ]);

        $event->menu->add([
            'text' => 'Reportes', 'icon' => 'fas fa-chart-line', 'classes' => self::MENU_DANGER,
            'submenu' => [
                ['text' => 'Reportes mensuales', 'url' => 'reportes-mensuales', 'icon' => 'fas fa-calendar-alt', 'active' => ['reportes-mensuales*']],
            ],
        ]);

        $this->addCertificadosMenu($event, $user);
        $this->addUsuariosMenu($event);
    }
}


    private function addCertificadosMenu(BuildingMenu $event, $user)
    {
        $submenu = [];

        // Configuración específica por rol
        if ($user->orol == 1) {
            // ADG (rol 1) - Ve todo el proceso
            $submenu = [
                ['text' => 'Ver Solicitudes CNA', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-envelope-open-text', 'active' => ['ver-solicitudes-noadeudos*']],
                ['text' => 'Solicitudes Aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up', 'active' => ['solicitudes-noadeudos*']],
                ['text' => 'Gestión CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks', 'active' => ['gestion-noadeudos*']],
                ['text' => 'CNA Emitidos', 'url' => 'certificados-emitidos', 'icon' => 'fas fa-paper-plane', 'active' => ['certificados-emitidos*']],
                ['text' => 'CNA Liberados', 'url' => 'certificados-liberados', 'icon' => 'fas fa-unlock-alt', 'active' => ['certificados-liberados*']],
            ];
        } elseif ($user->orol == 99) {
            // Super Admin (rol 99) - Ve todo + puede aprobar
            $submenu = [
                ['text' => 'Ver Solicitudes CNA', 'url' => 'ver-solicitudes-noadeudos', 'icon' => 'fas fa-envelope-open-text', 'active' => ['ver-solicitudes-noadeudos*']],
                ['text' => 'Solicitudes Aprobadas', 'url' => 'solicitudes-noadeudos', 'icon' => 'fas fa-thumbs-up', 'active' => ['solicitudes-noadeudos*']],
                ['text' => 'Gestión CNA', 'url' => 'gestion-noadeudos', 'icon' => 'fas fa-tasks', 'active' => ['gestion-noadeudos*']],
                ['text' => 'CNA Emitidos', 'url' => 'certificados-emitidos', 'icon' => 'fas fa-paper-plane', 'active' => ['certificados-emitidos*']],
                ['text' => 'CNA Liberados', 'url' => 'certificados-liberados', 'icon' => 'fas fa-unlock-alt', 'active' => ['certificados-liberados*']],
            ];
        }

        if (!empty($submenu)) {
            $event->menu->add([
                'text' => 'Certificados No Adeudo',
                'icon' => 'fas fa-certificate',
                'classes' => self::MENU_INFO,
                'submenu' => $submenu,
            ]);
        }
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