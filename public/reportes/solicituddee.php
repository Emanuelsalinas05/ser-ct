<?php


try {

    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";    

    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = 'solicitud/of_cna.jasper';

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser('usug1');
    $Conn->setPassword('u55gG7y3');
    $conexion = $Conn->getConnection();
    
    $stmnt = new Java("java.sql.Statement");
    $stmnt = $conexion->createStatement();

    $resultSet = new Java("java.sql.ResultSet");

    $param = new Java("java.util.HashMap");
    

    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir.$rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");
 
    header("Content-Disposition: attachment; filename=\"reporte_general_gestionCNA_DEE.pdf\"");
    header("Content-Length: " . strlen($pdf));
    header("Content-Type: application/pdf");
    header('Pragma: no-cache');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    set_time_limit(0);

    echo $pdf;

} catch (Exception $ex) {
    echo $ex;
}

?>

