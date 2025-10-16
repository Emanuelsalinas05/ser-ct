<?php
// Sanitiza
$elct_h = htmlspecialchars($elct ?? '', ENT_QUOTES, 'UTF-8');
$link_h = htmlspecialchars($linkcarpeta ?? '', ENT_QUOTES, 'UTF-8');
$year_h = htmlspecialchars(date('Y'), ENT_QUOTES, 'UTF-8');

// Subject + HTML
$mail->Subject = "DEE | Carpeta de Entrega-Recepción del CCT {$elct_h}";
$mail->isHTML(true);

// Cuerpo
$message = <<<HTML
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Carpeta E-R finalizada</title>
</head>
<body style="margin:0;background:#f5f6f8;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6f8;">
    <tr><td align="center">

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
          <td style="padding:28px 24px 8px 24px;font:700 18px 'Segoe UI',Arial,Helvetica,sans-serif;color:#111;">
            Carpeta finalizada y remitida al OIC
          </td>
        </tr>

        <!-- Datos CCT -->
        <tr>
          <td style="padding:0 24px 16px 24px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fff8d5;border:1px solid #f0e5a2;border-radius:8px;">
              <tr>
                <td style="padding:14px 16px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
                  <div style="font-weight:700;color:#8a1538;margin-bottom:6px;">Centro de Trabajo</div>
                  <div style="font-weight:600;margin-bottom:8px;">{$elct_h}</div>
                  <p style="margin:12px 0 0 0;line-height:1.5;">
                    C. TITULAR DEL ÓRGANO INTERNO DE CONTROL DE SEIEM<br><br><b>PRESENTE</b>
                  </p>
                  <p style="margin:12px 0 0 0;line-height:1.5;">
                    Con fundamento en el Artículo 17 del Reglamento para los Procesos de Entrega y Recepción y de Rendición de Cuentas de la Administración Pública del Estado de México, y en atención al oficio 210C0101010000S/1369/2022 de fecha 16 de marzo de 2022 emitido por el Órgano Interno de Control de los Servicios Educativos Integrados al Estado de México, se remite la carpeta que integra el acto protocolario de entrega y recepción del CCT {$elct_h} para los efectos a que haya lugar.
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- Link y CTA -->
        <tr>
          <td style="padding:0 24px 8px 24px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
            Consultar y descargar en:
            <a href="{$link_h}" target="_blank" style="color:#8a1538;text-decoration:underline;">{$link_h}</a>
          </td>
        </tr>
        <tr>
          <td align="center" style="padding:6px 24px 26px 24px;">
            <a href="{$link_h}" target="_blank"
               style="display:inline-block;text-decoration:none;font:600 14px 'Segoe UI',Arial,Helvetica,sans-serif;background:#8a1538;color:#ffffff;padding:11px 18px;border-radius:8px;">
              Abrir carpeta
            </a>
          </td>
        </tr>

        <!-- Nota -->
        <tr>
          <td style="padding:0 24px 20px 24px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
            <b>Se solicita respetuosamente acusar de recibido contestando a todos.</b>
          </td>
        </tr>
      </table>

      <!-- Footer -->
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#efeef0;">
        <tr>
          <td align="center" style="padding:14px 12px;">
            <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#666;">
              © {$year_h} SEIEM – Servicios Educativos Integrados al Estado de México.
            </div>
            <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#868686;">
              Mensaje automático.
            </div>
          </td>
        </tr>
      </table>

      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#2b0a16;">
        <tr><td style="height:8px;line-height:8px;font-size:0;">&nbsp;</td></tr>
      </table>

    </td></tr>
  </table>
</body>
</html>
HTML;

$mail->Body    = $message;
$mail->AltBody = "C. TITULAR DEL ÓRGANO INTERNO DE CONTROL DE SEIEM.\n\nSe remite la carpeta de E-R del CCT {$elct_h}.\nEnlace: {$linkcarpeta}\nSe solicita acusar de recibido.";

