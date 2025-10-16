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
    $mail->Password   = "jsav xcmh mhdi beup"; 
    $mail->CharSet    = 'UTF-8';
// Variables esperadas desde el controlador:

$elct        = isset($getct) ? ($getct->oclave . ' - ' . $getct->onombre_ct) : '';
$entrega     = $request->oentrega ?? '';
$recibe      = $request->orecibe ?? '';
$motivo      = $request->omotivo ?? '';
$fecha_entre = $request->ofecha_entrega ?? '';
$hora_entre  = $request->ohora_entrega ?? '';
$elcorreo    = $getoficio->ocorreo ?? '';

// Remitente = mismo usuario SMTP
$mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', "Notificación de Intervención E-R | {$elct}");

// Destinatarios
if (!empty($elcorreo) && filter_var($elcorreo, FILTER_VALIDATE_EMAIL)) {
    $mail->addAddress($elcorreo);
}

// Cuerpo desde plantilla
include __DIR__ . '/contenido.php';

$mail->isHTML(true);
$mail->Subject = 'Notificación para intervención de Entrega-Recepción';
$mail->Body    = $message ?? 'Sin contenido.';
$mail->AltBody = strip_tags(html_entity_decode($mail->Body, ENT_QUOTES, 'UTF-8'));

// Envío y bandera para el controlador
$MAIL_OK = false;

try {
    if ($mail->send()) {
        $MAIL_OK = true;

        // Actualiza onotifica_nivel si hay IDs válidos
        $idDepto = (int)($getoficio->id_ct ?? 0);
        $idEsc   = (int)($request->idct_escuela ?? 0);

        if ($idDepto > 0 && $idEsc > 0) {
            $mysqli = new mysqli(
                'db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com',
                'usug1',
                'u55gG7y3',
                'g1sereeb'
            );
            if (!$mysqli->connect_errno) {
                $mysqli->set_charset('utf8mb4');
                $stmt = $mysqli->prepare(
                    "UPDATE b3adg_intervenciones
                     SET onotifica_nivel = 1
                     WHERE idct_departamento = ? AND idct_escuela = ? AND ogenerada = 1 AND ofin = 0"
                );
                if ($stmt) {
                    $stmt->bind_param('ii', $idDepto, $idEsc);
                    $stmt->execute();
                    $stmt->close();
                }
                $mysqli->close();
            }
        }
    }
} catch (\Throwable $e) {
    // sin echo; solo log
    // error_log($e->getMessage());
    $MAIL_OK = false;
}
