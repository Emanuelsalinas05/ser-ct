<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Parámetros desde GET
$iduser   = $_GET['i1d3'] ?? 0;
$idreport = $_GET['idr3p0rt'] ?? 0;
$us       = $_GET['us'] ?? 0;
$unidadx  = $_GET['un1d'] ?? 0;

// Conexión a MySQL para obtener unidad (si aplica)
$unidad = '';
$mysqli = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", "usug1", "u55gG7y3", "g1sereeb");

if (!$mysqli->connect_error && $unidadx) {
    $query = "SELECT ct.onombre_ct 
              FROM g1organigrama o 
              LEFT JOIN g1centros_trabajo ct
              ON ct.kcvect = o.idct_departamento OR ct.kcvect = o.idct_subdireccion
              WHERE idct_escuela=$unidadx OR idct_supervicion=$unidadx OR idct_sector=$unidadx
              LIMIT 1";

    if ($result = $mysqli->query($query)) {
        if ($row = $result->fetch_assoc()) {
            $unidad = $row['onombre_ct'];
        }
    }
}

// Incluir selección del nombre del reporte
include 'selection-report.php'; // define $namereport y $anexoname

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

    // Parámetros para Jasper
    $param = new Java("java.util.HashMap");

    if (in_array($idreport, [4,5,6,7,10,11,14])) {
        $param->put("iduser", $iduser);
        $param->put("title", strtoupper($anexoname));
    } elseif ($idreport == 99) {
        $param->put("iduser", $iduser);
        $param->put("unit", $unidad);
    } else {
        $param->put("iduser", $iduser);
    }

    // Ejecutar reporte Jasper
    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf("/var/lib/tomcat9/webapps/g1rsereeb/" . $namereport, $param, $conexion);
    $pdf = java_cast($reporte, "string");

    // Enviar PDF al navegador
    $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $anexoname) . ".pdf";
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");

    echo $pdf;

} catch (JavaException $ex) {
    echo "? JavaException: " . $ex->getMessage();
    file_put_contents("error_jasper.txt", $ex);
} catch (Exception $ex) {
    echo "? PHP Exception: " . $ex->getMessage();
    file_put_contents("error_php.txt", $ex);
}
?>
