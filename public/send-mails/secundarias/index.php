<?php 

$username = "usug1";
$password = "u55gG7y3";
$database = "g1sereeb";
$mysqli = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", $username, $password, $database);

/*
$username = "root";
$password = "";
$database = "g1sereeb";
$mysqli = new mysqli("localhost", $username, $password, $database);
*/

$elid       = $datosacta->id;
$tipoacta   = $datosacta->id_tipoacta;
$correocc   = $datosacta->ocorreocc;

if($tipoacta==1) {
    $ctt  = $datosacta->oct_a;
    $elct = $datosacta->oct_a.' - '.$datosacta->onombre_ct_a;
} else if($tipoacta==2) {
    $ctt  = $datosacta->oct_ac;
    $elct = $datosacta->oct_ac.' - '.$datosacta->onombre_ct_ac;
}

$linkcarpeta = 'https://entregasrecepcion.seiem.gob.mx/storage/'.$datosacta->ourlcarpeta.$datosacta->onombrecarpeta;

if($datosacta->oenviocorreooic==0) {

    require_once 'PHPMailer/PHPMailerAutoload.php';
    require_once 'PHPMailer/class.smtp.php';

    $mail = new PHPMailer();
    $mail->isSMTP();                    
    $mail->Timeout    = 30;
    $mail->Mailer     = "smtp";
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465;          
    $mail->SMTPAuth   = true;
    $mail->Username   = "entregasrecepcion.desysa@seiem.edu.mx";
    $mail->Password   = "entregas2025";
    $mail->SMTPSecure = "ssl";

    //$mail->AddEmbeddedImage('Captura.PNG', 'PROGRAMA_SIMPOSIO_2019', 'Captura.PNG'); 

    // ✅ Cambiado a correo institucional
    $mail->From = "entregasrecepcion.desysa@seiem.edu.mx";
    $mail->FromName = utf8_decode("DESySA (CORREO PRUEBA) CARPETA DE E-R DEL CCT ".$elct);

    //$mail->addAddress($elmail1);     

    /*
    $mail->addAddress($ctts->oejemploz, '');     
    $mail->addAddress($ctts->oejemploz2, '');     
    $mail->addAddress($ctts->oejemploz3, ''); 
    */

    // Envío a correos oficiales de secundaria
    //$mail->addAddress('miguelcarlos.juarez@seiem.gob.mx');
    $mail->addAddress('erplanteles_desysa@seiem.gob.mx'); 
    $mail->addAddress('serct.15ADG0090Z@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0091Z@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0092Y@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0093X@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0094W@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0104M@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0105L@seiem.edu.mx');
    $mail->addAddress('serct.15ADG0106K@seiem.edu.mx');

    //$mail->addAddress('modernizacion.administrativa@dee.edu.mx');

    /*
    if($ctts->cct_subdireccion!=1) {
        $mail->addAddress($ctts->ocorreosub);
    }

    if($ctts->cct_departamento!=1) {
        $mail->addAddress($ctts->ocorreodep);
    }

    if($ctts->idct_sector!=1) {
        $mail->addAddress($ctts->ocorreoestructura);
    }

    if($ctts->cct_supervision!=1) {
        $mail->addAddress($ctts->ocorreoestructura2);
    }
    */

    $mail->addCC($correocc);
    // $mail->addBCC('carlos.sanchez@seiem.gob.mx'); // ❌ ya no se usa
    // $mail->addCC('modernizacion.administrativa@dee.edu.mx');

    include 'conten-mail.php';

    if(!$mail->send()) {
        echo '<BR>Mailer Error: '.$mail->ErrorInfo;
        $oky = 0;
    } else {
        $oky = 1;
        $sql = "UPDATE g1acta SET oenviocorreooic=1, oconcluida=1  WHERE id=$elid ";
        $mysqli->query($sql);
    }
}
?>
