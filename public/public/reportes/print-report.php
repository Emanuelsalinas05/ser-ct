<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Par�metro desde URL
$iduser = $_GET['i1d3'] ?? 0;

// Nombre del PDF con codificaci�n corregida
$anexoname = 'ACTA CIRCUNSTANCIADA DE ENTREGA Y RECEPCI�N DE CENTROS DE TRABAJO';

try {
    
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";    

    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = 'documento-actac.jasper';

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser("usug1");
    $Conn->setPassword("u55gG7y3");
    $conexion = $Conn->getConnection();

    $param = new Java("java.util.HashMap");
    $param->put("iduser", $iduser);

    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Verificaci�n del contenido generado
    if (empty($pdf)) {
        throw new Exception("Error al generar el archivo PDF.");
    }

    // ? Limpiar el nombre del archivo y forzar descarga
    $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $anexoname) . ".pdf";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    set_time_limit(0);

    echo $pdf;

} catch (JavaException $ex) {
    echo "? JavaException: " . $ex->getMessage();
    file_put_contents("error_actac.txt", $ex);
} catch (Exception $ex) {
    echo "? PHP Exception: " . $ex->getMessage();
    file_put_contents("error_php_actac.txt", $ex);
}
