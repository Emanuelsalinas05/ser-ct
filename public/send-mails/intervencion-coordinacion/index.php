<?php
// PHPMailer (legado)
require __DIR__ . '/../../PHPMailer/PHPMailerAutoload.php';
require __DIR__ . '/../../PHPMailer/class.smtp.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Timeout    = 30;
$mail->Host       = "smtp.gmail.com";
$mail->Port       = 587;             // TLS
$mail->SMTPSecure = "tls";
$mail->SMTPAuth   = true;
$mail->Username   = "entregasrecepcion.elemental@seiem.edu.mx";
$mail->Password   = "wmnq zkef ldej hfgt"; 
$mail->CharSet    = 'UTF-8';

// Variables esperadas desde el controlador:
$nivel_educativo = isset($getoficio) ? ($getoficio->onombre_ct ?? '') : '';
$numero_oficio   = isset($numero_oficio) ? $numero_oficio : '';
$fecha_oficio    = isset($fecha_oficio) ? $fecha_oficio : date('Y-m-d');
$total_intervenciones = isset($total_intervenciones) ? $total_intervenciones : 0;

// Remitente
$mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', "Notificación de Oficio Generado - DEE");

// Destinatario: Coordinación Académica y de Operación Educativa
$mail->addAddress('coordinacion.academica@seiem.edu.mx');

// Cuerpo desde plantilla
include __DIR__ . '/contenido.php';

$mail->isHTML(true);
$mail->Subject = 'Notificación de Oficio Generado - Intervenciones de Entrega-Recepción';
$mail->Body    = $message ?? 'Sin contenido.';
$mail->AltBody = strip_tags(html_entity_decode($mail->Body, ENT_QUOTES, 'UTF-8'));

// Envío
$MAIL_OK = false;

try {
    if ($mail->send()) {
        $MAIL_OK = true;
    }
} catch (\Throwable $e) {
    // Error silencioso, solo log
    // error_log($e->getMessage());
    $MAIL_OK = false;
}



