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

if ((int)$datosacta->oenviocorreooic === 0) 

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
    $mail->Password   = "jsav xcmh mhdi beup";
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
            foreach (preg_split('/[;,]+/', $row['ocorreosoc']) as $e) {
                $e = trim($e);
                if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
                    $destinos[] = strtolower($e);
                }
            }
        }
    }
    $rs->free();
}

$destinos = array_unique($destinos);
if (empty($destinos)) { return; } // no hay correo OIC configurado

foreach ($destinos as $email) { $mail->addAddress($email); }

// CC al capturista (opcional)
if ($correocc && filter_var($correocc, FILTER_VALIDATE_EMAIL)) {
    $mail->addCC($correocc);
}

// ====== Cuerpo del correo (plantilla) ======
$mail->isHTML(true);
include __DIR__ . '/conten-mail.php'; // usa $elct y $linkcarpeta para Subject/Body

// ====== Enviar y marcar ======
if ($mail->send()) {
    $mysqli->query("UPDATE g1acta SET oenviocorreooic=1, oconcluida=1 WHERE id={$elid}");
}