<?php
// Script de prueba para verificar el envío de correos de intervención

// Simular variables que espera el script
$getct = (object)[
    'oclave' => '15DPR0874I',
    'onombre_ct' => 'MIGUEL HIDALGO'
];

$request = (object)[
    'oentrega' => 'prueba1 OCTUBRE 2025',
    'orecibe' => 'prueba2 OCTUBRE 2025',
    'omotivo' => 'prueba',
    'ofecha_entrega' => '2025-10-22',
    'ohora_entrega' => '15:35',
    'idct_escuela' => 1
];

$getoficio = (object)[
    'id_ct' => 1,
    'ocorreo' => 'modernizacion.administrativa@dee.edu.mx'
];

echo "Iniciando prueba de envío de correo...\n";
echo "Centro de trabajo: {$getct->oclave} - {$getct->onombre_ct}\n";
echo "Entrega: {$request->oentrega}\n";
echo "Recibe: {$request->orecibe}\n";
echo "Motivo: {$request->omotivo}\n";
echo "Fecha: {$request->ofecha_entrega} {$request->ohora_entrega}\n";
echo "Correo destino: {$getoficio->ocorreo}\n\n";

// Incluir el script de correo
require_once __DIR__ . '/public/send-mails/intervencion-elemental/index.php';

if (isset($MAIL_OK) && $MAIL_OK) {
    echo "✅ CORREO ENVIADO EXITOSAMENTE\n";
} else {
    echo "❌ ERROR AL ENVIAR CORREO\n";
    if (isset($mail)) {
        echo "Error: " . $mail->ErrorInfo . "\n";
    }
}
?>
