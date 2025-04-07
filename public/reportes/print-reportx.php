<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Parámetros GET
$iduser   = $_GET['i1d3'] ?? 0;
$unidadx  = $_GET['un1d'] ?? 0;

// Obtener unidad desde la BD
$unidad = '';
$mysqli = new mysqli(
    "db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com",
    "usug1",
    "u55gG7y3",
    "g1sereeb"
);

if (!$mysqli->connect_error && $unidadx) {
    $query = "
        SELECT ct.onombre_ct 
        FROM g1organigrama o 
        LEFT JOIN g1centros_trabajo ct
        ON ct.kcvect = o.idct_departamento OR ct.kcvect = o.idct_subdireccion
        WHERE idct_escuela=$unidadx 
        OR idct_supervicion=$unidadx  
        OR idct_sector=$unidadx 
        LIMIT 1
    ";

    if ($result = $mysqli->query($query)) {
        if ($row = $result->fetch_assoc()) {
            $unidad = $row['onombre_ct'];
        }
    }
}

// Datos del reporte
$namereport = "solicitud/solicitud-cna.jasper";
$anexoname  = "SOLICITUD_NOADEUDOS";

try {
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');

    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";
    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = $namereport;

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser("usug1");
    $Conn->setPassword("u55gG7y3");
    $conexion = $Conn->getConnection();

    $param = new Java("java.util.HashMap");
    $param->put("iduser", $iduser);
    $param->put("unit", $unidad);

    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Verificar contenido del PDF
    if (empty($pdf) || strlen($pdf) < 1000) {
        file_put_contents("warning_reportx_log.txt", "?? PDF vacío para iduser=$iduser unidad=$unidadx\n", FILE_APPEND);
        exit("?? PDF no generado o vacío.");
    }

    $filename = $anexoname . ".pdf";
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    set_time_limit(0);

    echo $pdf;

} catch (JavaException $ex) {
    file_put_contents("error_print_reportx_java.txt", $ex);
    http_response_code(500);
    exit("Java error");
} catch (Exception $ex) {
    file_put_contents("error_print_reportx_php.txt", $ex);
    http_response_code(500);
    exit("PHP error");
}
?>
