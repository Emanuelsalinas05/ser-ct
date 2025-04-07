<?php 
switch ($idreport) {
    case 1:
    	$anexoname	= "1.1) Ordenamientos Juridico-Administrativos";
        $namereport = "marco-juridico.jasper";
    break;

    case 2:
    	$anexoname	= "5.1) Plantilla de personal";

        if($us==76){
            $namereport = "plantilla-personal.jasper";
        }else if($us==89){
            $namereport = "plantilla-personal-sec.jasper";
        }
    break;

    case 3:
    	$anexoname	= "5.3) Relacion de Servidores Publicos Comisionados";
    	$namereport = "plantilla-comisionados.jasper";
    break;

    case 4:
    	$anexoname	= "8.1) Inventario de bienes muebles inmuebles y semovientes";
    	$namereport = "inventario-bienes.jasper";
    break;

    case 5:
    	$anexoname	= "8.3) Inventario de existencias en almacenes";
    	$namereport = "inventario-almacen.jasper";
    break;

    case 6:
    	$anexoname	= "8.5) Relacion de los bienes bajo custodia del titular";
    	$namereport = "relacion-bienes-custodia.jasper";
    break;

    case 7:
    	$anexoname	= "9.1) Inventario de equipo de computo";
    	$namereport = "inventario-equipo.jasper";
    break;

    case 8:
    	$anexoname	= "13.1) Relacion de Archivos de tramite";
        $namereport = "relacion-archivos.jasper";
    break;

    case 9:
    	$anexoname	= "13.2) Relacion de archivos de concentracion o historico";
        $namereport = "relacion-archivos-historico.jasper";
    break;

    case 10:
    	$anexoname	= "13.4) Relacion de Documentos no convencionales o bibliohemerograficos";
    	$namereport = "documentos-noconvencionles.jasper";
    break;

    case 11:
    	$anexoname	= "14.1) Certificados de No Adeudo";
    	$namereport = "certificados-no-adeudo.jasper";
    break;

    case 12:
    	$anexoname	= "15.1) Informe de gestion plantilla";
    	$namereport = "informe-gestion-plantilla.jasper";
    break;

    case 13:
    	$anexoname	= "15.2) Informe de compromisos a 90 dias";
    	$namereport = "informe-compromisos.jasper";
    break;

    case 14:
    	$anexoname	= "18.1) Otros hechos";
    	$namereport = "otros-hechos.jasper";
    break;

    case 99:
        $namereport = 'solicitud/solicitud-cna.jasper';
        $anexoname  = "SOLICITUD_NOADEUDOS";
    break;
}

?>