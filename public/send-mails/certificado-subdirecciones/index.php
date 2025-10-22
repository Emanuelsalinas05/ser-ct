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
    $mail->Username   = "entregasrecepcion.subdirecciones@seiem.edu.mx";
    $mail->Password   = "jsav xcmh mhdi beup"; 
    $mail->CharSet    = 'UTF-8';

// Variables esperadas desde el controlador:
$elct        = isset($getct) ? ($getct->oclave . ' - ' . $getct->onombre_ct) : '';
$solicitante = $request->onombre_solicitante ?? '';
$tipo_cert   = $request->tipo_certificado ?? '';
$fecha_sol   = $request->ofecha ?? '';
$numero_oficio = $request->onumero_oficio ?? '';
$elcorreo    = $getoficio->ocorreo ?? '';

// Remitente = mismo usuario SMTP
$mail->setFrom('entregasrecepcion.subdirecciones@seiem.edu.mx', "Notificación de Certificado No Adeudo | {$elct}");

// Destinatarios
if (!empty($elcorreo) && filter_var($elcorreo, FILTER_VALIDATE_EMAIL)) {
    $mail->addAddress($elcorreo);
}

// Cuerpo desde plantilla
include __DIR__ . '/contenido.php';

$mail->isHTML(true);
$mail->Subject = 'Notificación de Certificado de No Adeudo - Aprobado por Subdirección';
$mail->Body    = $message ?? 'Sin contenido.';
$mail->AltBody = strip_tags(html_entity_decode($mail->Body, ENT_QUOTES, 'UTF-8'));

// Envío y bandera para el controlador
$MAIL_OK = false;

try {
    if ($mail->send()) {
        $MAIL_OK = true;

        // Actualiza onotifica_nivel si hay IDs válidos
        $idSubdir = (int)($getoficio->id_ct ?? 0);
        $idEsc   = (int)($request->idct_escuela ?? 0);

        if ($idSubdir > 0 && $idEsc > 0) {
            $mysqli = new mysqli(
                'db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com',
                'usug1',
                'u55gG7y3',
                'g1sereeb'
            );
            if (!$mysqli->connect_errno) {
                $mysqli->set_charset('utf8mb4');
                $stmt = $mysqli->prepare(
                    "UPDATE g1solicitudes_noadeudos
                     SET oenviado = 1, oaprobado_subdireccion = 1
                     WHERE id = ? AND ogenerado = 1"
                );
                if ($stmt) {
                    $stmt->bind_param('i', $request->solicitud_id);
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
