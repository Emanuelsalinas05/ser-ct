<?php
// Sanitiza variables
$nivel_h     = htmlspecialchars($nivel_educativo ?? '', ENT_QUOTES, 'UTF-8');
$oficio_h    = htmlspecialchars($numero_oficio ?? '', ENT_QUOTES, 'UTF-8');
$fecha_h     = htmlspecialchars($fecha_oficio ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8');
$total_h     = htmlspecialchars($total_intervenciones ?? 0, ENT_QUOTES, 'UTF-8');
$year_h      = htmlspecialchars(date('Y'), ENT_QUOTES, 'UTF-8');

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
              Notificación de Oficio Generado
            </td>
          </tr>

          <!-- Información del oficio -->
          <tr>
            <td style="padding:0 24px 16px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#e8f5e9;border:1px solid #c8e6c9;border-radius:8px;">
                <tr>
                  <td style="padding:14px 16px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
                    <div style="font-weight:700;color:#2e7d32;margin-bottom:6px;">Información del Oficio</div>
                    <div style="margin-bottom:8px;"><strong style="color:#1b5e20;">Nivel Educativo:</strong> {$nivel_h}</div>
                    <div style="margin-bottom:8px;"><strong style="color:#1b5e20;">Número de Oficio:</strong> {$oficio_h}</div>
                    <div style="margin-bottom:8px;"><strong style="color:#1b5e20;">Fecha de Generación:</strong> {$fecha_h}</div>
                    <div style="margin-bottom:8px;"><strong style="color:#1b5e20;">Total de Intervenciones:</strong> {$total_h}</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Mensaje -->
          <tr>
            <td style="padding:0 24px 16px 24px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
              <p>Se ha generado y finalizado un oficio que agrupa todas las intervenciones de entrega-recepción del nivel de dirección correspondiente.</p>
              <p>El proceso ha sido completado a nivel de DEE y está disponible para su revisión.</p>
            </td>
          </tr>

          <!-- CTA -->
          <tr>
            <td align="center" style="padding:6px 24px 26px 24px;">
              <a href="https://entregasrecepcion.seiem.gob.mx/solicitud-intervencion" target="_blank"
                 style="display:inline-block;text-decoration:none;font:600 14px 'Segoe UI',Arial,Helvetica,sans-serif;background:#8a1538;color:#ffffff;padding:11px 18px;border-radius:8px;">
                Ver Intervenciones
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



