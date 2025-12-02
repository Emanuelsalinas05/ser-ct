<?php
use Illuminate\Support\Facades\Auth;

$username = "usug1";
$password = "u55gG7y3";
$database = "g1sereeb";
$mysqli   = new mysqli("db-lab-01.cluster-cthpdfxrdfan.us-east-1.rds.amazonaws.com", $username, $password, $database);
if ($mysqli->connect_errno) { die('Error DB: '.$mysqli->connect_error); }
$mysqli->set_charset('utf8mb4');

$elid     = (int)$datosacta->id;
$tipoacta = (int)$datosacta->id_tipoacta;
$correocc = trim((string)$datosacta->ocorreocc);
$idctt    = (int)$datosacta->id_ct;

if ($tipoacta === 1) {
    $elct = $datosacta->oct_a.' - '.$datosacta->onombre_ct_a;
} else {
    $elct = $datosacta->oct_ac.' - '.$datosacta->onombre_ct_ac;
}

$linkcarpeta = 'https://entregasrecepcion.seiem.gob.mx/storage/'.$datosacta->ourlcarpeta.$datosacta->onombrecarpeta;

if ((int)$datosacta->oenviocorreooic === 0) {
    require_once __DIR__.'/../PHPMailer/PHPMailerAutoload.php';
    require_once __DIR__.'/../PHPMailer/class.smtp.php';

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Timeout    = 30;
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 587;          // TLS
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth   = true;
    $mail->Username   = "entregasrecepcion.elemental@seiem.edu.mx";
    $mail->Password   = "wmnq zkef ldej hfgt";
    $mail->CharSet    = 'UTF-8';

    // Remitente
    $mail->setFrom('entregasrecepcion.elemental@seiem.edu.mx', "DEE - Carpeta de E-R del CCT {$elct}");
// ====== Destinatarios (OIC) desde g1organigrama.ocorreosoc ======
$destinos = [];
$sql = "SELECT ocorreosoc
        FROM g1organigrama
        WHERE idct_escuela={$idctt}
           OR idct_supervicion={$idctt}
           OR idct_sector={$idctt}
        LIMIT 1";
if ($rs = $mysqli->query($sql)) {
    if ($row = $rs->fetch_assoc()) {
        if (!empty($row['ocorreosoc'])) {
            error_log("INFO: Correo OIC encontrado en BD: {$row['ocorreosoc']} para CCT: {$idctt}");
            foreach (preg_split('/[;,]+/', $row['ocorreosoc']) as $e) {
                $e = trim($e);
                if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
                    $destinos[] = strtolower($e);
                }
            }
        } else {
            error_log("WARNING: Campo ocorreosoc está vacío en g1organigrama para CCT: {$idctt}");
        }
    } else {
        error_log("WARNING: No se encontró registro en g1organigrama para CCT: {$idctt}");
    }
    $rs->free();
} else {
    error_log("ERROR en consulta SQL para obtener correo OIC: " . $mysqli->error);
}

$destinos = array_unique($destinos);

// Validar que se encontró correo del OIC
if (empty($destinos)) {
    error_log("ERROR: No se encontró correo OIC configurado en g1organigrama para CCT: {$idctt}");
    $oky = 0;
    return;
}

// Verificar que NO se esté usando el correo del capturista como destinatario principal
// El correo del capturista (ocorreocc) solo debe ir en CC, no como destinatario principal
if ($correocc && in_array(strtolower($correocc), $destinos)) {
    $destinos = array_filter($destinos, function($email) use ($correocc) {
        return strtolower($email) !== strtolower($correocc);
    });
    $destinos = array_values($destinos);
}

if (empty($destinos)) {
    error_log("ERROR: Después de filtrar, no quedan correos OIC válidos para CCT: {$idctt}");
    $oky = 0;
    return;
}

// Agregar destinatarios OIC (PRINCIPAL)
foreach ($destinos as $email) { 
    $mail->addAddress($email);
    error_log("INFO: Correo OIC agregado como destinatario principal: {$email} para CCT: {$idctt}");
}

// CC al capturista (opcional) - SOLO EN CC, NO COMO DESTINATARIO PRINCIPAL
if ($correocc && filter_var($correocc, FILTER_VALIDATE_EMAIL)) {
    $mail->addCC($correocc);
    error_log("INFO: Correo capturista agregado en CC: {$correocc} para CCT: {$idctt}");
}

// CC obligatorio a modernización administrativa
$mail->addCC('modernizacion.administrativa@dee.edu.mx');

// ====== Cuerpo del correo (plantilla) ======
$mail->isHTML(true);
include __DIR__ . '/conten-mail.php'; // usa $elct y $linkcarpeta para Subject/Body

// ====== Enviar y marcar ======
// IMPORTANTE: NO marcar oenviocorreooic=1 ni oconcluida=1 aquí
// El controlador verificará que el ZIP esté cargado antes de marcar como finalizado
// Solo establecer $oky para indicar si el correo se envió exitosamente
$oky = 0;
if ($mail->send()) {
    $oky = 1; // Correo enviado exitosamente
    // El controlador se encargará de marcar oenviocorreooic=1 y oconcluida=1
    // después de verificar que ocargacomprimido=1
} else {
    error_log("ERROR al enviar correo OIC: " . $mail->ErrorInfo);
    $oky = 0;
}
}