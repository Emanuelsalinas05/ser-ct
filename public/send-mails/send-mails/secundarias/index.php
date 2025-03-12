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


    $elid       = $datosacta->id;
    $tipoacta   = $datosacta->id_tipoacta;
    $correocc  = $datosacta->ocorreocc;


    if($tipoacta==1)
    {
        $ctt  = $datosacta->oct_a;
        $elct = $datosacta->oct_a.' - '.$datosacta->onombre_ct_a;
    }else if($tipoacta==2){
        $ctt  = $datosacta->oct_ac;
        $elct = $datosacta->oct_ac.' - '.$datosacta->onombre_ct_ac;
    }
      




    $linkcarpeta= 'https://entregasrecepcion.seiem.gob.mx/storage/'.$datosacta->ourlcarpeta.$datosacta->onombrecarpeta;



if($datosacta->oenviocorreooic==0)   
{

    require_once 'PHPMailer/PHPMailerAutoload.php';
    require_once 'PHPMailer/class.smtp.php';

    $mail = new PHPMailer();
    $mail->isSMTP();                    // Set mailer to use SMTP
    $mail->Timeout    =   30;
    $mail->Mailer     = "smtp";
    $mail->Host       = "smtp.gmail.com";     // Specify main and backup SMTP servers
    $mail->Port       = 465;          
    $mail->SMTPAuth   = true;             // Enable SMTP authentication
    $mail->Username   = "entregasrecepcion.desysa@seiem.edu.mx";        // SMTP username
    $mail->Password   = "entregas2025";          // SMTP password
    $mail->SMTPSecure = "ssl";          // Enable TLS encryption, `ssl` also accepte

    //$mail->AddEmbeddedImage('Captura.PNG', 'PROGRAMA_SIMPOSIO_2019', 'Captura.PNG'); 


    $mail->From = "carlos.sanchez@seiem.gob.mx";

    $mail->FromName = utf8_decode("DESySA (CORREO PRUEBA) CARPETA DE E-R DEL CCT ".$elct);

    //$mail->addAddress($elmail1);     // Add a recipient


 
/*
    $mail->addAddress($ctts->oejemploz, '');     // Add a recipient
    $mail->addAddress($ctts->oejemploz2, '');     // Add a recipient
    $mail->addAddress($ctts->oejemploz3, '');     // Add a recipient

*/



      //  $mail->addAddress('miguelcarlos.juarez@seiem.gob.mx');
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
        if($ctts->cct_subdireccion!=1)
        {
            $mail->addAddress($ctts->ocorreosub);
            //echo $ctts->ocorreosub.'<br>';
        }

        if($ctts->cct_departamento!=1)
        {
            $mail->addAddress($ctts->ocorreodep);
            //echo $ctts->ocorreodep.'<br>';
        }

        if($ctts->idct_sector!=1)
        {
            $mail->addAddress($ctts->ocorreoestructura);
            //echo $ctts->ocorreoestructura.'<br>';
        }

        if($ctts->cct_supervision!=1)
        {
            $mail->addAddress($ctts->ocorreoestructura2);
            //echo $ctts->ocorreoestructura2.'<br>';
        }
    */


    
    

    $mail->addCC($correocc);
    $mail->addBCC('carlos.sanchez@seiem.gob.mx');
      //$mail->addCC('modernizacion.administrativa@dee.edu.mx');


        include 'conten-mail.php';

        if(!$mail->send()) 
        {   
            echo '<BR>Mailer Error: '.$mail->ErrorInfo;
            $oky = 0;
        } else {
            //echo $message;
            //echo "<br><b style='color:green; font-size:12px;'>SE ENVIÓ LA CONTRASEÑA A TU CORREO<br></b><br>";
            $oky = 1;
              
            $sql = "UPDATE g1acta SET oenviocorreooic=1, oconcluida=1  WHERE id=$elid ";

            if ($mysqli->query($sql) === TRUE) 
            {
                //echo "ok";
            } else {
                //echo "Error updating record: " . $mysqli->error;
            }
        }


}



?>