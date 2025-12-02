<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Intervencion;

/**
 * Service Provider para construir el menú lateral según el rol del usuario
 * 
 * Genera dinámicamente el menú de navegación basado en:
 * - Rol del usuario (1=Admin, 2=Revisor, 3=Entregador, 99=Coordinador)
 * - Estado de actas en curso
 * - Permisos específicos por nivel
 */
class AdminMenuServiceProvider extends ServiceProvider
{
    private const MENU_PRIMARY = 'bg-primary text-white fw-bold';
    private const MENU_WARNING = 'bg-warning text-white fw-bold';
    private const MENU_SUCCESS = 'bg-success text-white fw-bold';
    private const MENU_DANGER  = 'bg-danger text-white fw-bold';
    private const MENU_INFO    = 'bg-info text-white fw-bold';

    /**
     * Registra el listener para construir el menú cuando se carga AdminLTE
     */
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

        // Verificar si el usuario actual tiene un acta circunstanciada en curso
        // Las actas circunstanciadas no requieren solicitud de intervención
        // Para administradores (rol 1), verificar si hay alguna acta circunstanciada en curso
        // IMPORTANTE: Si hay CUALQUIER acta circunstanciada en curso, ocultar el botón
        $actaCircunstanciadaEnCurso = \App\Models\DatosActa::where('oconcluida', 0)
            ->where('id_tipoacta', 2) // Acta circunstanciada
            ->exists();

        // Construir submenu de Intervención
        $submenuIntervencion = [];
        
        // Solo mostrar "Solicitud de intervención" si NO hay acta circunstanciada en curso
        // Las actas circunstanciadas no requieren solicitud de intervención
        if (!$actaCircunstanciadaEnCurso) {
            $submenuIntervencion[] = ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']];
        }
        
        $submenuIntervencion[] = ['text' => 'Intervención DEE', 'url' => 'intervenciones-niveles', 'icon' => 'fas fa-university', 'active' => ['intervenciones-niveles*']];
        $submenuIntervencion[] = ['text' => 'Información por niveles', 'url' => 'informacion-niveles', 'icon' => 'fas fa-info-circle', 'active' => ['informacion-niveles*']];

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => $submenuIntervencion,
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

        // Para revisores (rol 2), el menú de "Solicitud de intervención" debe estar siempre habilitado
        // para que siempre puedan crear una nueva intervención, independientemente del estado de las actas
        $submenuIntervencion = [];
        
        // Siempre mostrar "Solicitud de intervención" para el revisor (rol 2)
        $submenuIntervencion[] = ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']];

        // Agregar el menú de Intervención siempre
        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => $submenuIntervencion,
        ]);
        $this->addUsuariosMenu($event);
    }

private function buildEntregadorMenu(BuildingMenu $event, $user): void
{
    // Verificar si hay actas concluidas (finalizadas) para este CCT
    $actaConcluida = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('id_ct', $user->id_ct)
        ->where('oconcluida', 1) // Actas finalizadas
        ->where('oenviocorreooic', 1) // Con correo enviado
        ->where('ocargacomprimido', 1) // Con ZIP cargado
        ->orderBy('ofechafin', 'DESC')
        ->first();
    
    // Verificar si hay intervención activa (NO finalizada)
    $intervencionActiva = \App\Models\Intervencion::where('idct_escuela', $user->id_ct)
        ->where('ogenerada', 1)
        ->where('ofin', 0) // Solo intervenciones NO finalizadas
        ->where('istatus', '!=', 'B')
        ->orderBy('ofecha_realizacion', 'DESC')
        ->first();
    
    // Si hay acta concluida, verificar que la intervención esté finalizada
    if ($actaConcluida) {
        // Buscar la intervención asociada a esta acta concluida
        $intervencionAsociada = \App\Models\Intervencion::where('idct_escuela', $user->id_ct)
            ->where('ogenerada', 1)
            ->where('istatus', '!=', 'B')
            ->orderBy('ofecha_realizacion', 'DESC')
            ->first();
        
        // Si la intervención NO está finalizada, marcarla como finalizada
        if ($intervencionAsociada && $intervencionAsociada->ofin == 0) {
            \App\Models\Intervencion::where('id', $intervencionAsociada->id)
                ->update(['ofin' => 1]);
        }
    }
    
    // Si no hay intervención activa (no finalizada), ocultar menú
    // El CCT queda bloqueado hasta que se genere una nueva solicitud de intervención
    if (!$intervencionActiva) {
        // Solo mostrar "Entregas Realizadas" para ver el historial
        $event->menu->add([
            'text' => 'Entregas Realizadas',
            'url' => 'entregas-finalizadas',
            'icon' => 'fas fa-check-circle',
            'classes' => self::MENU_SUCCESS,
            'active' => ['entregas-finalizadas*'],
        ]);
        return;
    }
    
    // Acceso principal - Solo se muestra si hay intervención activa
    $event->menu->add([
        'text'    => 'Entrega Recepción',
        'url'     => 'entrega-recepcion',
        'icon'    => 'fas fa-file-signature',
        'classes' => self::MENU_PRIMARY,
        'active'  => ['entrega-recepcion*'],
    ]);
    
    // Verificar si tiene un acta NO concluida (en curso) asociada a esta intervención
    $actaEnCurso = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('id_ct', $user->id_ct)
        ->where('oconcluida', 0) // Solo actas en curso
        ->first();
    
    // Si hay acta en curso, verificar si el proceso está completamente finalizado
    if ($actaEnCurso) {
        $procesoFinalizado = ($actaEnCurso->ocargacomprimido == 1 && 
                             $actaEnCurso->oenviocorreooic == 1);
        
        // Si el proceso está completamente finalizado, ocultar menú
        // Se necesita una nueva intervención
        if ($procesoFinalizado) {
            // Marcar la intervención como finalizada si aún no lo está
            \App\Models\Intervencion::where('idct_escuela', $user->id_ct)
                ->where('ogenerada', 1)
                ->where('ofin', 0)
                ->where('istatus', '!=', 'B')
                ->update(['ofin' => 1]);
            
            // Solo mostrar "Entregas Realizadas"
            $event->menu->add([
                'text' => 'Entregas Realizadas',
                'url' => 'entregas-finalizadas',
                'icon' => 'fas fa-check-circle',
                'classes' => self::MENU_SUCCESS,
                'active' => ['entregas-finalizadas*'],
            ]);
            return;
        }
    }

    $actaCircunstanciadaEnCurso = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('id_ct', $user->id_ct)
        ->where('oconcluida', 0)
        ->where('id_tipoacta', 2)
        ->exists();

    $idTipoActa = \App\Models\DatosActa::where('id_user', $user->id)
        ->where('oconcluida', 0)
        ->value('id_tipoacta');
    $mostrar15 = ((int)$idTipoActa === 1);

    $mostrar14 = false;
    if (!$actaCircunstanciadaEnCurso) {
        $mostrar14 = \App\Models\Solicitudnoadeudo::where('id_ct', $user->id_ct)
            ->where('status', '!=', 'B')
            ->where(fn($q) => $q->whereNull('ofinalizado')->orWhere('ofinalizado', 0))
            ->exists();
    }

    $items = [];
    
    if (!$actaCircunstanciadaEnCurso) {
        $items[] = ['text'=>'Solicitar Certificado','url'=>'solicitud-certificado','icon'=>'fas fa-file-signature','classes'=>self::MENU_INFO,'active'=>['solicitud-certificado*']];
    }

    $items[] = ['text'=>'1. MARCO JURÍDICO','url'=>'marco-juridico','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['marco-juridico*']];
    $items[] = ['text'=>'5. RECURSOS HUMANOS','url'=>'recursos-humanos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['recursos-humanos*','plantilla-personal*','plantilla-comisionados*']];
    $items[] = ['text'=>'8. SITUACIÓN DE LOS RECURSOS MATERIALES','url'=>'recursos-materiales','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['recursos-materiales*','inventario-bienes*','inventario-almacen*','relacion-bienes-custodia*']];
    $items[] = ['text'=>'9. SITUACIÓN DE LAS TIC´S','url'=>'situacion-tics','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['situacion-tics*','inventario-equipo*']];
    $items[] = ['text'=>'13. ARCHIVOS','url'=>'archivos','icon'=>'far fa-file-alt','classes'=>self::MENU_WARNING,'active'=>['archivos*','relacion-archivos*','relacion-archivos-historico*','documentos-noconvencionales*']];

    if ($mostrar14 && !$actaCircunstanciadaEnCurso) {
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

        // Verificar si hay acta circunstanciada en curso
        // Las actas circunstanciadas no requieren solicitud de intervención
        // Para coordinadores (rol 99), verificar si hay alguna acta circunstanciada en curso
        // IMPORTANTE: Si hay CUALQUIER acta circunstanciada en curso, ocultar el botón
        $actaCircunstanciadaEnCurso = \App\Models\DatosActa::where('oconcluida', 0)
            ->where('id_tipoacta', 2) // Acta circunstanciada
            ->exists();

        // Construir submenu de Intervención
        $submenuIntervencion = [];
        
        // Solo mostrar "Solicitud de intervención" si NO hay acta circunstanciada en curso
        if (!$actaCircunstanciadaEnCurso) {
            $submenuIntervencion[] = ['text' => 'Solicitud de intervención', 'url' => 'solicitud-intervencion', 'icon' => 'fas fa-file-signature', 'active' => ['solicitud-intervencion*']];
        }
        
        $submenuIntervencion[] = ['text' => 'Reportes de intervención', 'url' => 'reportes-intervencion', 'icon' => 'fas fa-file-export', 'active' => ['reportes-intervencion*']];

        $event->menu->add([
            'text' => 'Intervención', 'icon' => 'fas fa-toolbox', 'classes' => self::MENU_WARNING,
            'submenu' => $submenuIntervencion,
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