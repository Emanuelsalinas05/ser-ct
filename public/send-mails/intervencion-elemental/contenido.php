<?php
// Sanitiza
$elct_h     = htmlspecialchars($elct ?? '', ENT_QUOTES, 'UTF-8');
$entrega_h  = htmlspecialchars($entrega ?? '', ENT_QUOTES, 'UTF-8');
$recibe_h   = htmlspecialchars($recibe ?? '', ENT_QUOTES, 'UTF-8');
$motivo_h   = htmlspecialchars($motivo ?? '', ENT_QUOTES, 'UTF-8');
$fecha_h    = htmlspecialchars($fecha_entre ?? '', ENT_QUOTES, 'UTF-8');
$hora_h     = htmlspecialchars($hora_entre ?? '', ENT_QUOTES, 'UTF-8');

// URL del botón (fija a solicitud-intervencion, o usa $action_url si lo envías)
$base_url   = 'https://entregasrecepcion.seiem.gob.mx/solicitud-intervencion';
$btn_url    = isset($action_url) && $action_url ? $action_url : $base_url;
$btn_h      = htmlspecialchars($btn_url, ENT_QUOTES, 'UTF-8');
$year_h     = htmlspecialchars(date('Y'), ENT_QUOTES, 'UTF-8');

$message = <<<HTML
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Notificación SER-CT</title>
</head>
<body style="margin:0;background:#f5f6f8;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6f8;">
    <tr>
      <td align="center">

        <!-- Header -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#8a1538;">
          <tr>
            <td align="center" style="padding:18px 12px;">
              <div style="font:700 20px/1.2 'Segoe UI',Arial,Helvetica,sans-serif;color:#fff;">SER-CT</div>
              <div style="font:600 12px/1.2 'Segoe UI',Arial,Helvetica,sans-serif;color:#f0d7df;letter-spacing:.5px;">ACTO DE ENTREGA – RECEPCIÓN</div>
            </td>
          </tr>
        </table>

        <!-- Card -->
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="max-width:640px;margin:24px 12px;background:#fff;border-radius:10px;">
          <tr>
            <td style="padding:28px 24px 12px 24px;font:700 18px 'Segoe UI',Arial,Helvetica,sans-serif;color:#111;">
              Notificación de intervención
            </td>
          </tr>

          <!-- Datos CCT en card amarilla -->
          <tr>
            <td style="padding:0 24px 16px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fff8d5;border:1px solid #f0e5a2;border-radius:8px;">
                <tr>
                  <td style="padding:14px 16px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
                    <div style="font-weight:700;color:#8a1538;margin-bottom:6px;">Centro de Trabajo</div>
                    <div style="font-weight:600;margin-bottom:8px;">{$elct_h}</div>
                    <div><strong style="color:#5c0f28;">Entrega:</strong> {$entrega_h}</div>
                    <div><strong style="color:#5c0f28;">Recibe:</strong> {$recibe_h}</div>
                    <div><strong style="color:#5c0f28;">Motivo:</strong> {$motivo_h}</div>
                    <div><strong style="color:#5c0f28;">Fecha y hora:</strong> {$fecha_h} {$hora_h} hrs</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td align="center" style="padding:6px 24px 26px 24px;">
              <a href="{$btn_h}" target="_blank"
                 style="display:inline-block;text-decoration:none;font:600 14px 'Segoe UI',Arial,Helvetica,sans-serif;background:#8a1538;color:#ffffff;padding:11px 18px;border-radius:8px;">
                Ver intervención
              </a>
            </td>
          </tr>
        </table>

        <!-- Footer institucional -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#efeef0;">
          <tr>
            <td align="center" style="padding:14px 12px;">
              <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#666;">
                © {$year_h} SEIEM – Servicios Educativos Integrados al Estado de México.
              </div>
              <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#868686;">
                Este es un mensaje automático. No respondas.
              </div>
            </td>
          </tr>
        </table>

        <!-- Barra inferior -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#2b0a16;">
          <tr><td style="height:8px;line-height:8px;font-size:0;">&nbsp;</td></tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>
HTML;
