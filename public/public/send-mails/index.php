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
    $idctt = $datosacta->id_ct;

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
    $mail->Username   = "entregasrecepcion.elemental@seiem.edu.mx";        // SMTP username
    $mail->Password   = "entregas2025";          // SMTP password
    $mail->SMTPSecure = "ssl";          // Enable TLS encryption, `ssl` also accepte

    //$mail->AddEmbeddedImage('Captura.PNG', 'PROGRAMA_SIMPOSIO_2019', 'Captura.PNG'); 


    $mail->From = "carlos.sanchez@seiem.gob.mx";

    $mail->FromName = utf8_decode("DEE (CORREO PRUEBA) CARPETA DE E-R DEL CCT ".$elct);

    //$mail->addAddress($elmail1);     // Add a recipient


 
/*
    $mail->addAddress($ctts->oejemploz, '');     // Add a recipient
    $mail->addAddress($ctts->oejemploz2, '');     // Add a recipient
    $mail->addAddress($ctts->oejemploz3, '');     // Add a recipient

*/

if(Auth::user()->onivel=='ELEMENTAL')
{  
   
        $quer_usr = "   SELECT * FROM g1organigrama WHERE idct_escuela=$idctt OR ( idct_supervicion=$idctt OR idct_sector=$idctt ) ";
        $rs_usr = $mysqli->query($quer_usr);
        $row_usr = $rs_usr->fetch_assoc();
        $ocorreosub         = $row_usr["ocorreosub"];
        $ocorreodep         = $row_usr["ocorreodep"];
        $ocorreoestructura  = $row_usr["ocorreoestructura"];
        $ocorreoestructura2 = $row_usr["ocorreoestructura2"];

        if($ocorreosub!=NULL){
            $mail->addAddress($ocorreosub);
        }
        if($ocorreodep!=NULL){
            $mail->addAddress($ocorreodep);
        }
        if($ocorreoestructura!=NULL){
            $mail->addAddress($ocorreoestructura);
        }
        if($ocorreoestructura2!=NULL){
            $mail->addAddress($ocorreoestructura2); 
        }

    //$mail->addAddress('miguelcarlos.juarez@seiem.gob.mx');
    $mail->addAddress('modernizacion.administrativa@dee.edu.mx');
/*
            
            $mail->addAddress('adg0078e.extension@dee.edu.mx'); 
            $mail->addAddress('adg0120d.subrecursos@dee.edu.mx'); 
            $mail->addAddress('adg0088l.juridico@dee.edu.mx'); 
            $mail->addAddress('adg0087m.extension.entrega@dee.edu.mx'); 
            $mail->addAddress('adg0086n.juridiconeza@dee.edu.mx'); 
            $mail->addAddress('adg0079d@dee.edu.mx'); 
            $mail->addAddress('adg0081s.planeva.estadistica@dee.edu.mx'); 
            $mail->addAddress('adg0082r.recursos@dee.edu.mx'); 
            $mail->addAddress('adg0122b.recursos@dee.edu.mx'); 
            $mail->addAddress('adg0083q.subrecursos@dee.edu.mx'); 
            $mail->addAddress('adg0080t.subrecursos@dee.edu.mx'); 
            $mail->addAddress('adg0085o.subrecursos@dee.edu.mx'); 
            $mail->addAddress('luis.archundia@dee.edu.mx');

*/



}else if(Auth::user()->onivel=='SECUNDARIA'){

        //$mail->addAddress('miguelcarlos.juarez@seiem.gob.mx');

        $mail->addAddress('guie.anaya@seiem.gob.mx');
        $mail->addAddress('adan.garrido@seiem.gob.mx'); 
        $mail->addAddress('luis.dominguez@seiem.gob.mx');





}



    
    

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