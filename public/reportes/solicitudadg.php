<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Recibir parámetros vía POST
$idd      = $_POST['c3t3'] ?? '';
$fechadg  = $_POST['f3c4'] ?? '';
$namefile = $idd . '_' . $fechadg;

try {
    // Incluir JavaBridge
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    // Alternativa local para producción:
    // include('/var/lib/tomcat9/webapps/JavaBridgeTemplate721/java/Java.inc');

    // Conexión JDBC
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";
    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = "solicitud/of_cna_.jasper";

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser("usug1");
    $Conn->setPassword("u55gG7y3");
    $conexion = $Conn->getConnection();

    // Parámetros para el reporte
    $param = new Java("java.util.HashMap");
    $param->put("idd", $idd);
    $param->put("fechadg", $fechadg);

    // Ejecutar JasperReport
    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Validación de PDF
    if (empty($pdf) || strlen($pdf) < 1000) {
        file_put_contents("warning_solicitudadg_log.txt", "?? PDF vacío para idd=$idd, fecha=$fechadg\n", FILE_APPEND);
        exit("?? PDF no generado o vacío.");
    }

    $filename = "reporte_" . $namefile . ".pdf";

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
    file_put_contents("error_solicitudadg_java.txt", $ex);
    http_response_code(500);
    exit("Java error.");
} catch (Exception $ex) {
    file_put_contents("error_solicitudadg_php.txt", $ex);
    http_response_code(500);
    exit("PHP error.");
}
?>
