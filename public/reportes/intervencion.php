<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Parámetros GET
$fecha1 = $_GET['fecha1'] ?? '';
$fecha2 = $_GET['fecha2'] ?? '';

// Configuración de archivo
$reportFile = "intervencionx2.jasper";
$filename   = "SOLICITUD_INTERVENCION_E_R.pdf";

try {
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";    

    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser("usug1");
    $Conn->setPassword("u55gG7y3");
    $conexion = $Conn->getConnection();

    // Parámetros del reporte
    $param = new Java("java.util.HashMap");
    $param->put("fecha1", $fecha1);
    $param->put("fecha2", $fecha2);

    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $reportFile, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Validar contenido
    if (empty($pdf) || strlen($pdf) < 1000) {
        file_put_contents("warning_intervencion_rango_log.txt", "?? PDF vacío para fecha1=$fecha1, fecha2=$fecha2\n", FILE_APPEND);
        exit("?? PDF no generado o vacío.");
    }

    // Headers para descarga
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    set_time_limit(0);

    echo $pdf;

} catch (JavaException $ex) {
    file_put_contents("error_intervencionx2_java.txt", $ex);
    http_response_code(500);
    exit("Java error");
} catch (Exception $ex) {
    file_put_contents("error_intervencionx2_php.txt", $ex);
    http_response_code(500);
    exit("PHP error");
}
?>
