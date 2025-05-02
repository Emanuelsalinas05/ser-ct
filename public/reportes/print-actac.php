<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// Par�metro desde URL
$iduser = $_GET['i1d3'] ?? 0;

// Nombre del PDF con codificaci�n corregida
$anexoname = 'ACTA CIRCUNSTANCIADA DE ENTREGA Y RECEPCI�N DE CENTROS DE TRABAJO';

// Verificar que el par�metro iduser sea v�lido
if ($iduser == 0) {
    die('Error: El par�metro iduser es obligatorio.');
}

try {
    // Incluir la librer�a JavaBridge
    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    
    // Configuraci�n de la base de datos
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";    

    // Ruta del reporte Jasper
    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = 'documento-actac.jasper';

    // Conexi�n con la base de datos
    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser("usug1");
    $Conn->setPassword("u55gG7y3");
    $conexion = $Conn->getConnection();

    // Verificar la conexi�n
    if (!$conexion) {
        throw new Exception("Error de conexi�n a la base de datos.");
    }

    // Definir los par�metros del reporte
    $param = new Java("java.util.HashMap");
    $param->put("iduser", $iduser);

    // Ejecutar el reporte Jasper
    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir . $rep, $param, $conexion);
    
    // Verificaci�n del contenido generado
    if (empty($reporte)) {
        throw new Exception("Error al generar el archivo PDF.");
    }

    // Convertir el reporte a cadena de texto
    $pdf = java_cast($reporte, "string");

    // ? Limpiar el nombre del archivo y forzar descarga
    $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $anexoname) . ".pdf";

    // Establecer las cabeceras para la descarga del PDF
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    set_time_limit(0);

    // Enviar el PDF al navegador
    echo $pdf;

} catch (JavaException $ex) {
    // Manejo de excepciones de Java
    echo "? JavaException: " . $ex->getMessage();
    file_put_contents("error_actac.txt", $ex->getMessage(), FILE_APPEND);
} catch (Exception $ex) {
    // Manejo de excepciones de PHP
    echo "? PHP Exception: " . $ex->getMessage();
    file_put_contents("error_php_actac.txt", $ex->getMessage(), FILE_APPEND);
}
?>
