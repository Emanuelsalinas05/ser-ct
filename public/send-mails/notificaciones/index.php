<?php

require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'PHPMailer/class.smtp.php';

// Conexión a la base de datos
$mysqli = new mysqli(
    "db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com",
    "usug1",
    "u55gG7y3",
    "g1sereeb"
);

// Datos necesarios desde Laravel
$elct       = $intervencionct->oct_nivel . ' ' . $intervencionct->onivel_educativo;
$idct       = $intervencionct->idct_departamento;
$fechafinn  = $intervencionct->ofechafin;
$linkcarpeta = 'https://entregasrecepcion.seiem.gob.mx/' . $intervencionct->ourl;

// Configurar PHPMailer
$mail = new PHPMailer();
$mail->CharSet = 'UTF-8'; // ✅ Evita caracteres raros
$mail->isSMTP();
$mail->Timeout    = 30;
$mail->Mailer     = "smtp";
$mail->Host       = "smtp.gmail.com";
$mail->Port       = 465;
$mail->SMTPAuth   = true;
$mail->Username   = "entregasrecepcion.elemental@seiem.edu.mx";
$mail->Password   = "entregas2025";
$mail->SMTPSecure = "ssl";

// ⚠️ Aquí sustituimos el correo antiguo de Juan Carlos por uno institucional nuevo
$mail->setFrom('notificaciones.er@seiem.edu.mx', 'NOTIFICACIÓN DE INTERVENCIÓN PARA E-R');

// Destinatarios
$mail->addAddress('modernizacion.administrativa@dee.edu.mx');

// Opcional: agregar BCC o más CC si lo necesitas
// $mail->addBCC('otro.correo@seiem.gob.mx');

include 'contenido.php'; // Define $message

$mail->Subject  = "NOTIFICACIÓN DE INTERVENCIÓN PARA ENTREGA-RECEPCIÓN";
$mail->Body     = $message;
$mail->AltBody  = strip_tags($message);
$mail->isHTML(true);

$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer'      => false,
        'verify_peer_name' => false,
        'allow_self_signed'=> true,
    ]
];

// Enviar y actualizar en la base de datos
if (!$mail->send()) {
    echo '<br>❌ Mailer Error: ' . $mail->ErrorInfo;
    $oky = 0;
} else {
    echo '✅ Notificación enviada correctamente.';
    $oky = 1;

    $sql = "UPDATE b3adg_intervenciones 
            SET onotificado = 1 
            WHERE idct_departamento = $idct 
              AND ofechafin = '$fechafinn' ";

    $mysqli->query($sql);
}
?>
