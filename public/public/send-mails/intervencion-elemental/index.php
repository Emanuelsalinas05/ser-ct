<?php 



    $username = "usug1";
    $password = "u55UG$1n";
    $database = "g1sereeb";
    $mysqli = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", $username, $password, $database);
/*
    $username = "root";
    $password = "";
    $database = "g1sereeb";
    $mysqli = new mysqli("localhost", $username, $password, $database);
*/

    $elct       = $getct->oclave.' - '.$getct->onombre_ct; 
    $entrega    = $request->oentrega;
    $recibe     = $request->orecibe;
    $motivo     = $request->omotivo;
    $fecha_entre= $request->ofecha_entrega;
    $hora_entre = $request->ohora_entrega;

    $elcorreo   = $getoficio->ocorreo;



        require_once 'PHPMailer/PHPMailerAutoload.php';
        require_once 'PHPMailer/class.smtp.php';

        $mail = new PHPMailer();
        $mail->isSMTP();                    // Set mailer to use SMTP
        $mail->Timeout    =   30;
        $mail->Mailer     = "smtp";
        $mail->Host       = "smtp.gmail.com";     // Specify main and backup SMTP servers
        $mail->Port       = 465;          
        $mail->SMTPAuth   = true;             // Enable SMTP authentication
        $mail->Username   = "entregasrecepcion.elemental@seiem.edu.mx";        // SMTP username
        $mail->Password   = "entregas2025";          // SMTP password
        $mail->SMTPSecure = "ssl";          // Enable TLS encryption, `ssl` also accepte

        //$mail->AddEmbeddedImage('Captura.PNG', 'PROGRAMA_SIMPOSIO_2019', 'Captura.PNG'); 


        $mail->From = "carlos.sanchez@seiem.gob.mx";

        $mail->FromName = utf8_decode("(CORREO PRUEBA 2.0) NOTIFICACIÓN PARA INTERVENCIÓN DE E-R DE ".$elct);


        //$mail->addAddress('carlos.sanchez@seiem.gob.mx');
        $mail->addAddress($elcorreo);
        $mail->addCC('modernizacion.administrativa@dee.edu.mx');

        $mail->addBCC('carlos.sanchez@seiem.gob.mx');


        include 'contenido.php';

        if(!$mail->send()) 
        {   
            echo '<BR>Mailer Error: '.$mail->ErrorInfo;
            $oky = 0;
        } else {
            //echo $message;
            //echo "<br><b style='color:green; font-size:12px;'>SE ENVIÓ LA CONTRASEÑA A TU CORREO<br></b><br>";
            $oky = 1;
              
            $sql = "UPDATE b3adg_intervenciones  SET  onotifica_nivel = 1 
                    WHERE idct_departamento = $getoficio->id_ct
                    AND idct_escuela = $request->idct_escuela 
                    AND ogenerada = 1";

            if ($mysqli->query($sql) === TRUE) 
            {
                //echo "ok";
            } else {
                //echo "Error updating record: " . $mysqli->error;
            }
        }





?>