<?php

require __DIR__ . '/../../PHPMailer/PHPMailerAutoload.php';
require __DIR__ . '/../../PHPMailer/class.smtp.php';

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8'; // ? Para que los acentos no se vean mal

// ? Variables recibidas desde el controlador Laravel
$elct        = $getct->oclave . ' - ' . $getct->onombre_ct;
$entrega     = $request->oentrega;
$recibe      = $request->orecibe;
$motivo      = $request->omotivo;
$fecha_entre = $request->ofecha_entrega;
$hora_entre  = $request->ohora_entrega;
$elcorreo    = $getoficio->ocorreo;

// ? Conexión a base de datos (si se actualiza la tabla)
$mysqli = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", "usug1", "u55gG7y3", "g1sereeb");

// ? Configurar correo
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->Port       = 465;
$mail->SMTPAuth   = true;
$mail->Username   = 'entregasrecepcion.elemental@seiem.edu.mx';
$mail->Password   = 'entregas2025';
$mail->SMTPSecure = 'ssl';

// ?? ESTE CORREO YA NO DEBE USARSE:
// Puedes reemplazarlo por ejemplo con: 'notificaciones.er@seiem.edu.mx'
$mail->setFrom('emanuel.salinas@seiem.gob.mx', "NOTIFICACIÓN DE INTERVENCIÓN E-R");

$mail->addAddress($elcorreo);
$mail->addCC('modernizacion.administrativa@dee.edu.mx');

// ? Contenido desde archivo HTML
include 'contenido.php'; // $message debe estar definido ahí

$mail->Subject  = "NOTIFICACIÓN PARA INTERVENCIÓN DE ENTREGA-RECEPCIÓN";
$mail->Body     = $message;
$mail->AltBody  = strip_tags($message);
$mail->isHTML(true);

$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer'      => false,
        'verify_peer_name' => false,
        'allow_self_signed'=> true,
    ],
];

// ? Enviar correo
if (!$mail->send()) {
    echo '? Error al enviar: ' . $mail->ErrorInfo;
} else {
    echo '? Correo enviado correctamente.';

    // ? Actualización de tabla si fue exitosa
    $sql = "UPDATE b3adg_intervenciones 
            SET onotifica_nivel = 1 
            WHERE idct_departamento = {$getoficio->id_ct}
              AND idct_escuela = {$request->idct_escuela} 
              AND ogenerada = 1";
    
    $mysqli->query($sql);
}
