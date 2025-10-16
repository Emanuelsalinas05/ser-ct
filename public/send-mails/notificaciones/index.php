<?php
// PHPMailer (legado)
require __DIR__ . '/../../PHPMailer/PHPMailerAutoload.php';
require __DIR__ . '/../../PHPMailer/class.smtp.php';


$oky = 0;

/* ==== Datos esperados del controlador ==== */
$elct        = isset($intervencionct) ? trim($intervencionct->oct_nivel.' '.$intervencionct->onivel_educativo) : '';
$idct        = isset($intervencionct) ? (int)$intervencionct->idct_departamento : 0;
$fechafinn   = isset($intervencionct) ? (string)$intervencionct->ofechafin : '';
$linkcarpeta = isset($intervencionct) ? ('https://entregasrecepcion.seiem.gob.mx/'.$intervencionct->ourl) : '';
$destinatario = $destinatario ?? null;

/* ==== PHPMailer SMTP ==== */
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Timeout    = 30;
$mail->Host       = 'smtp.gmail.com';
$mail->Port       = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth   = true;
$mail->Username   = 'entregasrecepcion.elemental@seiem.edu.mx';
$mail->Password   = 'jsav xcmh mhdi beup'; // usa APP password
$mail->CharSet    = 'UTF-8';

$mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', 'NOTIFICACIÓN DE INTERVENCIÓN PARA E-R');

/* ==== Destinatario ==== */
if ($destinatario && filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
    $mail->addAddress($destinatario);
} else {
    $mail->addAddress('modernizacion.administrativa@dee.edu.mx');
}

/* ==== Render del HTML ==== */
ob_start();
include __DIR__.'/contenido.php'; // define $message
$mail->isHTML(true);
$mail->Subject = 'Notificación para intervención de Entrega-Recepción';
$mail->Body    = $message;
$mail->AltBody = strip_tags($message);




/* ==== Enviar y actualizar DB ==== */
try {
    if ($mail->send()) {
        echo '✅ Notificación enviada correctamente.';
        $oky = 1;

        $mysqli = @new mysqli(
            'db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com',
            'usug1',
            'u55gG7y3',
            'g1sereeb'
        );
        if ($mysqli && !$mysqli->connect_errno) {
            $mysqli->set_charset('utf8mb4');
            $stmt = $mysqli->prepare(
                "UPDATE b3adg_intervenciones
                 SET onotificado = 1
                 WHERE idct_departamento = ? AND ofechafin = ?"
            );  
        }
    } else {
        echo '❌ Mailer Error: '.$mail->ErrorInfo;
        $oky = 0;
    }
} catch (\Throwable $e) {
    $oky = 0;
}
