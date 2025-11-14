<?php
// PHPMailer (legado)
require __DIR__ . '/../../PHPMailer/PHPMailerAutoload.php';
require __DIR__ . '/../../PHPMailer/class.smtp.php';

$oky = 0;

/* ==== Datos esperados del controlador ==== */
// Para intervenciones (legado)
$elct        = isset($intervencionct) ? trim($intervencionct->oct_nivel.' '.$intervencionct->onivel_educativo) : '';
$idct        = isset($intervencionct) ? (int)$intervencionct->idct_departamento : 0;
$fechafinn   = isset($intervencionct) ? (string)$intervencionct->ofechafin : '';
$linkcarpeta = isset($intervencionct) ? ('https://entregasrecepcion.seiem.gob.mx/'.$intervencionct->ourl) : '';
$destinatario = $destinatario ?? null;

// Para archivos cargados (nuevo)
$elct = isset($getct) ? ($getct->oclave . ' - ' . $getct->onombre_ct) : $elct;

/* ==== PHPMailer SMTP ==== */
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Timeout    = 30;
$mail->Host       = 'smtp.gmail.com';
$mail->Port       = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth   = true;
$mail->Username   = 'entregasrecepcion.elemental@seiem.edu.mx';
$mail->Password   = 'wmnq zkef ldej hfgt'; // usa APP password
$mail->CharSet    = 'UTF-8';

// Determinar el tipo de notificación
$es_archivo_cargado = isset($request->tipo_proceso) && in_array($request->tipo_proceso, ['ADG', 'DEE']);
$es_finalizacion_er = isset($request->tipo_proceso) && $request->tipo_proceso === 'FINALIZACIÓN ENTREGA-RECEPCIÓN';

if ($es_finalizacion_er) {
    $mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', 'NOTIFICACIÓN DE FINALIZACIÓN - ENTREGA-RECEPCIÓN');
    $mail->Subject = 'Entrega-Recepción Finalizada - Proceso Completado';
} elseif ($es_archivo_cargado) {
    $mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', 'NOTIFICACIÓN DE ARCHIVO CARGADO - CNA');
    $mail->Subject = 'Notificación de archivo cargado - Certificados No Adeudo';
} else {
    $mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', 'NOTIFICACIÓN DE INTERVENCIÓN PARA E-R');
    $mail->Subject = 'Notificación para intervención de Entrega-Recepción';
}

/* ==== Destinatario ==== */
// Para finalización de Entrega-Recepción, usar correo del titular con fallback
if ($es_finalizacion_er && isset($getoficio)) {
    $elcorreo = $getoficio->ocorreo ?? '';
    if (!empty($elcorreo) && filter_var($elcorreo, FILTER_VALIDATE_EMAIL)) {
        $mail->addAddress($elcorreo);
        $mail->addCC('modernizacion.administrativa@dee.edu.mx');
    } else {
        $mail->addAddress('modernizacion.administrativa@dee.edu.mx');
    }
} elseif ($destinatario && filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
    $mail->addAddress($destinatario);
    $mail->addCC('modernizacion.administrativa@dee.edu.mx');
} else {
    $mail->addAddress('modernizacion.administrativa@dee.edu.mx');
}

// CC obligatorio a modernización administrativa solo si no es el destinatario principal
if (($destinatario && filter_var($destinatario, FILTER_VALIDATE_EMAIL)) || 
    ($es_finalizacion_er && isset($getoficio) && !empty($getoficio->ocorreo) && filter_var($getoficio->ocorreo, FILTER_VALIDATE_EMAIL))) {
    // Ya se agregó CC arriba, no duplicar
}

/* ==== Render del HTML ==== */
ob_start();
include __DIR__.'/contenido.php'; // define $message
$mail->isHTML(true);
$mail->Body    = $message;
$mail->AltBody = strip_tags($message);




/* ==== Enviar y actualizar DB ==== */
try {
    if ($mail->send()) {
        echo '✅ Notificación enviada correctamente.';
        $oky = 1;

        // Solo actualizar DB para intervenciones (legado)
        if (!$es_archivo_cargado) {
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
        }
    } else {
        echo '❌ Mailer Error: '.$mail->ErrorInfo;
        $oky = 0;
    }
} catch (\Throwable $e) {
    $oky = 0;
}

// Bandera para el controlador
$MAIL_OK = $oky;
