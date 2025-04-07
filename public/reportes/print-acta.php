<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Recibe el par�metro del usuario
$iduser = $_GET['i1d3'] ?? 0;
$anexoname = 'ACTA DE ENTREGA Y RECEPCI�N';

try {
    // Incluye JavaBridge desde servidor local
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    // Opcionalmente, puedes usar la ruta local:
    // include('/var/lib/tomcat9/webapps/JavaBridgeTemplate721/java/Java.inc');

    // Configuraci�n de conexi�n JDBC
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";
    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = 'documento-acta.jasper';

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser('usug1');
    $Conn->setPassword('u55gG7y3');
    $conexion = $Conn->getConnection();

    // Par�metro para Jasper
    $param = new Java("java.util.HashMap");
    $param->put("iduser", $iduser);

    // Ejecutar JasperReport
    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Validaci�n si el PDF est� vac�o
    if (empty($pdf) || strlen($pdf) < 1000) {
        file_put_contents("warning_print_acta.txt", "PDF vac�o para iduser=$iduser\n", FILE_APPEND);
        exit("?? PDF no generado o vac�o.");
    }

    // Nombre del archivo para descarga
    $filename = 'acta_' . $iduser . '.pdf';

    // Headers para forzar descarga
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    set_time_limit(0);

    echo $pdf;

} catch (JavaException $ex) {
    file_put_contents("error_print_acta_java.txt", $ex);
    http_response_code(500);
    exit("Java error.");
} catch (Exception $ex) {
    file_put_contents("error_print_acta_php.txt", $ex);
    http_response_code(500);
    exit("PHP error.");
}
?>
