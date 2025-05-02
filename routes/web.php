<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationqrController;
use App\Http\Controllers\_deeintervencionesController;
use App\Http\Controllers\_xCaoeController;
use App\Http\Controllers\_xCaoehController;
use App\Http\Controllers\_adgIntervencionesController;

use App\Http\Controllers\_adgInfonivelesController;
use App\Http\Controllers\_adgIntervencionesgeneradasexcelController;
use App\Http\Controllers\_adgIntervencionesreportesController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\_AdminSolicitudesController;
use App\Http\Controllers\_AdminSolicitudesAprobadasController;
use App\Http\Controllers\_AdminSolicitudesGestionController;


use App\Http\Controllers\UsersLevelsController;
use App\Http\Controllers\Users01direccionController;
use App\Http\Controllers\Users02subdireccionController;
use App\Http\Controllers\Users03departamentoController;
use App\Http\Controllers\Users04sectorController;
use App\Http\Controllers\Users05supervicionController;
use App\Http\Controllers\ActaController;
use App\Http\Controllers\EntregasRecepcionController;
use App\Http\Controllers\FinalizadasController;
use App\Http\Controllers\EntregasRecepcionHistoricoController;
use App\Http\Controllers\ReviewAvanceacta;
use App\Http\Controllers\ReviewOk;
use App\Http\Controllers\ReviewOkx;

use App\Http\Controllers\CentrosTrabajoController;

use App\Http\Controllers\CentrosTrabajo01Controller;


use App\Http\Controllers\CentrosTrabajo04Controller;
use App\Http\Controllers\CentrosTrabajo05Controller;

use App\Http\Controllers\_xEstructuractController;
use App\Http\Controllers\_xEstructuractdesController;

use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\RegistroActaController;
use App\Http\Controllers\DatosCentroController;
use App\Http\Controllers\AnexosActoController;
use App\Http\Controllers\OrdenJuridico;
use App\Http\Controllers\PlantillaPersonalController;
use App\Http\Controllers\PlantillaComisionadosController;
use App\Http\Controllers\RecursosMaterialesController;
use App\Http\Controllers\RminventarioBienes;
use App\Http\Controllers\RminventarioAlmacen;
use App\Http\Controllers\RminventarioCustodias;
use App\Http\Controllers\SituacionTics;
use App\Http\Controllers\RmarchivosTramite;
use App\Http\Controllers\RmarchivosHistorico;
use App\Http\Controllers\RmarchivosNoconvencionales;
use App\Http\Controllers\RmcertificadosNoadeudos;
use App\Http\Controllers\RminformeGestion;
use App\Http\Controllers\Rmcompromisos90dias;
use App\Http\Controllers\RmotrosHechos;

use App\Http\Controllers\SolicitudCernoadeudo;

use App\Http\Controllers\DatasExportController;

use App\Http\Controllers\xxxfilesController;

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});

Auth::routes();

/*  VALIDACIÓN DE QR DE ANEXO ELECTRÓNICO   */
Route::resource('validation-qr', ValidationqrController::class);

Route::resource('usuarios-niveles', UsersLevelsController::class);


Route::middleware(["auth"])->group(function() 
{

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*  -----   RUTAS DEL ADMINISTRADOR     -----   */
    // USUARIOS
    Route::resource('usuarios', AdminController::class);

    Route::get('usuarios-subdireccion', [CentrosTrabajo01Controller::class, 'ussub'])
            ->name('admin.users.users-levels.02subdireccion.index');

    Route::get('usuarios-departamento', [CentrosTrabajo01Controller::class, 'usdep'])
            ->name('admin.users.users-levels.03departamento.index');

    Route::get('usuarios-sector', [CentrosTrabajo01Controller::class, 'ussec'])
            ->name('admin.users.users-levels.04sector.index');

    Route::get('usuarios-supervision', [CentrosTrabajo01Controller::class, 'ussup'])
            ->name('admin.users.users-levels.05supervision.index');

    Route::resource('usuarios-levels', CentrosTrabajo01Controller::class);



    //CONSULTA DE E-R
    Route::resource('entregas-recepcion', EntregasRecepcionController::class);
    //Route::get('/entregas-recepcion/', [EntregasRecepcionController::class, 'show'])->name('admin.er.show');
    //Route::get('entregas-recepcion/buscar', 'EntregasRecepcionController@busqueda');
    Route::prefix('check')->name('entregas-recepcion.check.')->group(function () {
        Route::get('marco-juridico/{id}', [ReviewAvanceacta::class, 'marcjuridico'])->name('marco-juridico');
        Route::get('recursos-humanos/{id}', [ReviewAvanceacta::class, 'rhumanos'])->name('recursos-humanos');
        Route::get('recursos-materiales/{id}', [ReviewAvanceacta::class, 'rmateriales'])->name('recursos-materiales');
        Route::get('situacion-tics/{id}', [ReviewAvanceacta::class, 'situaciontics'])->name('situacion-tics');
        Route::get('archivos/{id}', [ReviewAvanceacta::class, 'carchivos'])->name('archivos');
        Route::get('no-adeudos/{id}', [ReviewAvanceacta::class, 'cernoadeudos'])->name('no-adeudos');
        Route::get('informe-gestion/{id}', [ReviewAvanceacta::class, 'infogestion'])->name('informe-gestion');
        Route::get('otros-hechos/{id}', [ReviewAvanceacta::class, 'otrosh'])->name('otros-hechos');
    });

    Route::prefix('ok')->name('entregas-finalizadas.ok.')->group(function () {
        Route::get('marco-juridico/{id}', [ReviewOk::class, 'marcjuridico'])->name('marco-juridico');
        Route::get('recursos-humanos/{id}', [ReviewOk::class, 'rhumanos'])->name('recursos-humanos');
        Route::get('recursos-materiales/{id}', [ReviewOk::class, 'rmateriales'])->name('recursos-materiales');
        Route::get('situacion-tics/{id}', [ReviewOk::class, 'situaciontics'])->name('situacion-tics');
        Route::get('archivos/{id}', [ReviewOk::class, 'carchivos'])->name('archivos');
        Route::get('no-adeudos/{id}', [ReviewOk::class, 'cernoadeudos'])->name('no-adeudos');
        Route::get('informe-gestion/{id}', [ReviewOk::class, 'infogestion'])->name('informe-gestion');
        Route::get('otros-hechos/{id}', [ReviewOk::class, 'otrosh'])->name('otros-hechos');
    });


    // CENTROS DE TRABAJO
    Route::resource('centros-de-trabajo', CentrosTrabajoController::class);

    Route::resource('cts-estructura', CentrosTrabajo01Controller::class);

    // 
    Route::resource('organitation-ct', OrganigramaController::class);
    Route::resource('review-acta', ReviewAvanceacta::class);

    



    Route::get('file-export', [DatasExportController::class, 'fileExport'])->name('file-export');






/*  -----   RUTAS DEL USUARIO           -----   */
    //  DATOS ACTA
    Route::resource('datos-acta', RegistroActaController::class);
    //  DATOS DEL CENTRO DE TRABAJO 
    Route::resource('centro-trabajo', DatosCentroController::class);
    //  DATOS DEL ACTA, AVANCE DE ENTREGA-RECEPCION 
    Route::resource('entrega-recepcion', ActaController::class);
    //  HISTORICO DE ENTREGA-RECEPCION
    Route::prefix('history')->name('entregas-historico.history.')->group(function () {
        Route::get('marco-juridico/{id}', [ReviewOkx::class, 'marcjuridico'])->name('marco-juridico');
        Route::get('recursos-humanos/{id}', [ReviewOkx::class, 'rhumanos'])->name('recursos-humanos');
        Route::get('recursos-materiales/{id}', [ReviewOkx::class, 'rmateriales'])->name('recursos-materiales');
        Route::get('situacion-tics/{id}', [ReviewOkx::class, 'situaciontics'])->name('situacion-tics');
        Route::get('archivos/{id}', [ReviewOkx::class, 'carchivos'])->name('archivos');
        Route::get('no-adeudos/{id}', [ReviewOkx::class, 'cernoadeudos'])->name('no-adeudos');
        Route::get('informe-gestion/{id}', [ReviewOkx::class, 'infogestion'])->name('informe-gestion');
        Route::get('otros-hechos/{id}', [ReviewOkx::class, 'otrosh'])->name('otros-hechos');
    });


    Route::resource('solicitud-certificado', SolicitudCernoadeudo::class);

    //  AVANCE DE NEXOS
    Route::resource('avances-anexos', AnexosActoController::class);
    //  1.  MARCO JURIDICO 
    Route::resource('marco-juridico', OrdenJuridico::class);
    //  5.  RECURSOS HUMANOS 
    Route::get('recursos-humanos', [App\Http\Controllers\AnexosActoController::class, 'recursoshumanos'])->name('documentos.recursos-humanos.index');
        Route::resource('plantilla-personal', PlantillaPersonalController::class);
        Route::resource('plantilla-comisionados', PlantillaComisionadosController::class);
    //  8.  SITUACIÓN DE LOS RECURSOS MATERIALES  
    Route::get('situacion-recursos-materiales', [App\Http\Controllers\AnexosActoController::class, 'recursosmateriales'])->name('documentos.situacion-recursos-materiales.index');
        Route::resource('inventario-bienes', RminventarioBienes::class);
        Route::resource('inventario-almacen', RminventarioAlmacen::class);
        Route::resource('relacion-bienes-custodia', RminventarioCustodias::class);
        Route::resource('recursos-materiales', RecursosMaterialesController::class);
    //  9.  SITUACIÓN DE LAS TIC´S  
    Route::get('situacion-tics', [App\Http\Controllers\AnexosActoController::class, 'situaciontics'])
        ->name('documentos.situacion-tics.index');
        Route::resource('inventario-equipo', SituacionTics::class);
    //  13. ARCHIVOS 
    Route::get('archivos',[App\Http\Controllers\AnexosActoController::class,'archivos'])->name('documentos.archivos.index');
    Route::resource('relacion-archivos',RmarchivosTramite::class);
    Route::resource('relacion-archivos-historico',RmarchivosHistorico::class);
    Route::resource('documentos-noconvencionles',RmarchivosNoconvencionales::class);
    //  14. CERTIFICADOS DE NO ADEUDO  
    Route::get('certificados-no-adeudos', [App\Http\Controllers\AnexosActoController::class, 'noadeudos'])->name('documentos.certificados-no-adeudos.index');
    Route::resource('certificados-no-adeudo',RmcertificadosNoadeudos::class);
    //  15. INFORME DE GESTIÓN  
    Route::get('informe-gestion',[App\Http\Controllers\AnexosActoController::class,'informegestion'])->name('documentos.informe-gestion.index');
    Route::resource('informe-gestion-plantilla',RminformeGestion::class);
    Route::resource('informe-compromisos',Rmcompromisos90dias::class);
    //  18. OTROS HECHOS 
    Route::get('otroshechos', [App\Http\Controllers\AnexosActoController::class, 'otroshechos'])->name('documentos.otros-hechos.index');
    Route::resource('otros-hechos',RmotrosHechos::class);

    //  DOCUMENTOS
    Route::resource('documentos', AnexosActoController::class);


    // PARA LA AUTORIDAD INMEDIATA
    Route::resource('solicitud-intervencion', _adgIntervencionesController::class);
    Route::resource('reportes-intervencion', _adgIntervencionesreportesController::class);

    // PARA LA DEE
    Route::resource('intervenciones-niveles', _deeintervencionesController::class);


    // GESTION CERTIFCIADOS ADG / AUTORIDADES INMEDIATAS
    Route::resource('ver-solicitudes-noadeudos', _AdminSolicitudesController::class);
    Route::resource('solicitudes-noadeudos', _AdminSolicitudesAprobadasController::class);

    // DEE
    Route::resource('gestion-noadeudos', _AdminSolicitudesGestionController::class);
    Route::resource('certificados-liberados', _xCaoeController::class);
    
    // CAOE  CNA EMITIDOS
    Route::resource('certificados-emitidos', _xCaoehController::class);


    Route::get('/reportes-mensuales', [_adgIntervencionesgeneradasexcelController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/print-reporte-actos', [ReportesMensualesController::class, 'reporteActos'])->name('reporte.actos');
    Route::get('/reportes/print-reporte-intervencion', [ReportesMensualesController::class, 'reporteIntervencion'])->name('reporte.intervencion');
    Route::get('/reportes/print-reporte-noadeudos', [ReportesMensualesController::class, 'reporteNoAdeudos'])->name('reporte.noadeudos');

    
    Route::resource('informacion-niveles', _adgInfonivelesController::class);
    Route::resource('estructura-elemental', _xEstructuractController::class);
    Route::resource('estructura-desysa', _xEstructuractdesController::class);




});



Route::resource('formatos-archivos', xxxfilesController::class);