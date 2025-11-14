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
$elct        = isset($getct) ? ($getct->oclave . ' - ' . $getct->onombre_ct) : '';
$solicitante = $request->onombre_solicitante ?? '';
$tipo_cert   = $request->tipo_certificado ?? '';
$fecha_sol   = $request->ofecha ?? '';
$numero_oficio = $request->onumero_oficio ?? '';
$elcorreo    = $getoficio->ocorreo ?? '';

// Remitente = mismo usuario SMTP
$mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', "Notificación de Certificado No Adeudo | {$elct}");


// Destinatarios
if (!empty($elcorreo) && filter_var($elcorreo, FILTER_VALIDATE_EMAIL)) {
    $mail->addAddress($elcorreo);
} else {
    // Si no hay correo del titular, enviar a modernización administrativa como principal
    $mail->addAddress('modernizacion.administrativa@dee.edu.mx');
}

// CC obligatorio a modernización administrativa
// Solo agregar CC si ya no es el destinatario principal
if (!empty($elcorreo) && filter_var($elcorreo, FILTER_VALIDATE_EMAIL)) {
    $mail->addCC('modernizacion.administrativa@dee.edu.mx');
}

// Cuerpo desde plantilla
include __DIR__ . '/contenido.php';

$mail->isHTML(true);
// Determinar asunto según estado
$estado_cert = isset($request->estado) && $request->estado === 'LIBERADO' ? 'LIBERADO' : 'APROBADO';
if ($estado_cert === 'LIBERADO') {
    $mail->Subject = 'Certificado de No Adeudo Liberado - Listo para Recoger';
} else {
    $mail->Subject = 'Notificación de Solicitud de Certificado de No Adeudo';
}
$mail->Body    = $message ?? 'Sin contenido.';
$mail->AltBody = strip_tags(html_entity_decode($mail->Body, ENT_QUOTES, 'UTF-8'));

// Envío y bandera para el controlador
$MAIL_OK = false;

try {
    if ($mail->send()) {
        $MAIL_OK = true;

        // Actualiza la base de datos si hay IDs válidos
        $idSolicitud = (int)($request->solicitud_id ?? 0);
        $idCt = (int)($request->id_ct ?? 0);

        if ($idSolicitud > 0 && $idCt > 0) {
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
                    $stmt->bind_param('i', $idSolicitud);
                    $stmt->execute();
                    $stmt->close();
                }
                $mysqli->close();
            }
        }
    }
} catch (\Throwable $e) {
    // sin echo; solo log
    error_log("Error en envío de correo certificado: " . $e->getMessage());
    $MAIL_OK = false;
}
