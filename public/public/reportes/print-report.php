<?php

$iduser   = $_GET['i1d3'];
$idreport = $_GET['idr3p0rt'];
$us       = $_GET['us'];
$unidadx   = $_GET['un1d'];


    $username = "usug1";
    $password = "u55UG$1n";
    $database = "g1sereeb";
    $mysqli = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", $username, $password, $database);

/*

$quer_usr ="SELECT o.idct_departamento, o.cct_departamento , ct.onombre_ct,
            o.idct_subdireccion,o.cct_subdireccion, ct.onombre_ct
            FROM g1organigrama o 
            LEFT JOIN g1centros_trabajo ct
            ON ct.kcvect = o.idct_departamento 
            or ct.kcvect = o.idct_subdireccion
            WHERE idct_escuela=$unidadx 
            OR idct_supervicion=$unidadx  
            OR idct_sector=$unidadx ";
$rs_usr = $mysqli->query($quer_usr);


$row_usr = $rs_usr->fetch_assoc();
$cct_departamento = $row_usr["cct_departamento"];
$cct_subdireccion = $row_usr["cct_subdireccion"];
$onombre_ct = $row_usr["onombre_ct"];


if($cct_departamento==1){
    $unidad = $onombre_ct;
}else if($cct_departamento>1){
    $unidad = $onombre_ct;
}

*/

include 'selection-report.php';
/*
echo $anexoname.'<br>'.$namereport;
*/
try {

    include('http://10.15.10.41:8080/JavaBridgeTemplate721/java/Java.inc');
    $cad = "jdbc:mysql://db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com:3306/g1sereeb";    

    $dir = "/var/lib/tomcat9/webapps/g1rsereeb/";
    $rep = $namereport;

    $Conn = new Java("JdbcConnection");
    $Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setConnectString($cad);
    $Conn->setUser('usug1');
    $Conn->setPassword('u55UG$1n');
    $conexion = $Conn->getConnection();
    
    $stmnt = new Java("java.sql.Statement");
    $stmnt = $conexion->createStatement();

    $resultSet = new Java("java.sql.ResultSet");

    $param = new Java("java.util.HashMap");
    
    
    
        if ($idreport==4||$idreport==5||$idreport==6||$idreport==7||$idreport==10||$idreport==11||$idreport==14) 
        {   
    $param->put("iduser",  $iduser ); 
    $param->put("title",  strtoupper($anexoname) );

        }else if($idreport==99){

    $param->put("iduser",  $iduser );
    $param->put("unit",  $unidad );

        }else{

    $param->put("iduser",  $iduser );
        
        }

    $runmanager = new JavaClass("net.sf.jasperreports.engine.JasperRunManager");
    $reporte = $runmanager->runReportToPdf($dir.$rep, $param, $conexion);
    $pdf = java_cast($reporte, "string");
 
    header("Content-disposition:  filename=$anexoname.pdf");
    header("Content-Length: " . strlen($pdf));
    header("Content-type: application/pdf");
    header('Pragma: no-cache');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    set_time_limit(0);

    echo $pdf;

} catch (Exception $ex) {
    echo $ex;
}

?>

