<?php
// Sanitiza variables para notificaciones de archivos cargados
$elct_h           = htmlspecialchars($elct ?? '', ENT_QUOTES, 'UTF-8');
$solicitante_h    = htmlspecialchars($request->onombre_solicitante ?? '', ENT_QUOTES, 'UTF-8');
$tipo_proceso_h   = htmlspecialchars($request->tipo_proceso ?? '', ENT_QUOTES, 'UTF-8');
$fecha_carga_h    = htmlspecialchars($request->fecha_carga ?? '', ENT_QUOTES, 'UTF-8');
$url_archivo_h    = htmlspecialchars($request->url_archivo ?? '', ENT_QUOTES, 'UTF-8');
$year_h           = htmlspecialchars(date('Y'), ENT_QUOTES, 'UTF-8');

// Determinar el tipo de proceso para el mensaje
$proceso_texto = '';
$proceso_color = '#8a1538';
$tipo_proceso_val = isset($request->tipo_proceso) ? trim($request->tipo_proceso) : '';
$es_finalizacion_er = ($tipo_proceso_val === 'FINALIZACIÓN ENTREGA-RECEPCIÓN');

if ($es_finalizacion_er) {
    $proceso_texto = 'Finalización de Entrega-Recepción';
    $proceso_color = '#198754';
} elseif ($tipo_proceso_val == 'ADG') {
    $proceso_texto = 'Archivo de Gestión Cargado';
    $proceso_color = '#8a1538';
} elseif ($tipo_proceso_val == 'DEE') {
    $proceso_texto = 'Archivo DEE Cargado';
    $proceso_color = '#2c5aa0';
}

$message = <<<HTML
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Notificación de Archivo Cargado</title>
</head>
<body style="margin:0;background:#f5f6f8;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6f8;">
    <tr><td align="center">

      <!-- Header -->
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:{$proceso_color};">
        <tr><td align="center" style="padding:18px 12px;">
          <div style="font:700 20px/1.2 'Segoe UI',Arial,Helvetica,sans-serif;color:#fff;">SER-CT</div>
          <div style="font:600 12px/1.2 'Segoe UI',Arial,Helvetica,sans-serif;color:#f0d7df;letter-spacing:.5px;">
            <?php 
            if ($es_finalizacion_er) {
                echo 'ENTREGA-RECEPCIÓN FINALIZADA';
            } else {
                echo 'CERTIFICADO DE NO ADEUDO';
            }
            ?>
          </div>
        </td></tr>
      </table>

      <!-- Card -->
      <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="max-width:640px;margin:24px 12px;background:#fff;border-radius:10px;">
        <tr><td style="padding:28px 24px 12px 24px;font:700 18px 'Segoe UI',Arial,Helvetica,sans-serif;color:#111;">
          <?php 
          if ($es_finalizacion_er) {
              echo 'Entrega-Recepción Finalizada - Proceso Completado';
          } else {
              echo 'Notificación de archivo cargado';
          }
          ?>
        </td></tr>

        <!-- Datos CCT en card amarilla -->
        <tr><td style="padding:0 24px 16px 24px;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fff8d5;border:1px solid #f0e5a2;border-radius:8px;">
            <tr><td style="padding:14px 16px;font:14px 'Segoe UI',Arial,Helvetica,sans-serif;color:#333;">
              <div style="font-weight:700;color:#8a1538;margin-bottom:6px;">Centro de Trabajo</div>
              <div style="font-weight:600;margin-bottom:8px;">{$elct_h}</div>
              <div><strong style="color:#5c0f28;">Responsable:</strong> {$solicitante_h}</div>
              <div><strong style="color:#5c0f28;">Tipo de Proceso:</strong> {$proceso_texto}</div>
              <?php if ($es_finalizacion_er && $tipo_proceso_val === 'FINALIZACIÓN ENTREGA-RECEPCIÓN'): ?>
              <div><strong style="color:#5c0f28;">Fecha de Finalización:</strong> <?php echo htmlspecialchars($request->fecha_finalizacion ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?></div>
              <div style="margin-top:12px;padding:12px;background:#d1e7dd;border-left:4px solid #198754;color:#0f5132;font-weight:600;border-radius:4px;">
                ✓ <strong>Entrega-Recepción Finalizada</strong><br>
                El proceso de entrega-recepción ha sido completado exitosamente. El acta y todos sus anexos han sido revisados y aprobados.
              </div>
              <?php elseif ($tipo_proceso_val == 'ADG' || $tipo_proceso_val == 'DEE'): ?>
              <div><strong style="color:#5c0f28;">Fecha de Carga:</strong> {$fecha_carga_h}</div>
              <p style="margin:12px 0 0 0;line-height:1.4;">
                Se ha cargado un archivo escaneado para la gestión de Certificados de No Adeudo. 
                Una vez cargado el archivo escaneado, se notifica a la DEE para que realice las acciones correspondientes.
              </p>
              <p style="margin:8px 0 0 0;line-height:1.4;">
                <strong>Enlace al archivo:</strong>
                <a href="{$url_archivo_h}" target="_blank" style="color:#8a1538;word-break:break-all;">{$url_archivo_h}</a>
              </p>
              <?php endif; ?>
            </td></tr>
          </table>
        </td></tr>

        <!-- CTA -->
        <?php if (!$es_finalizacion_er): ?>
        <tr><td align="center" style="padding:6px 24px 26px 24px;">
          <a href="{$url_archivo_h}" target="_blank"
             style="display:inline-block;text-decoration:none;font:600 14px 'Segoe UI',Arial,Helvetica,sans-serif;background:{$proceso_color};color:#ffffff;padding:11px 18px;border-radius:8px;">
            Ver Archivo Cargado
          </a>
        </td></tr>
        <?php else: ?>
        <tr><td align="center" style="padding:6px 24px 26px 24px;">
          <a href="https://entregasrecepcion.seiem.gob.mx/finalizadas" target="_blank"
             style="display:inline-block;text-decoration:none;font:600 14px 'Segoe UI',Arial,Helvetica,sans-serif;background:{$proceso_color};color:#ffffff;padding:11px 18px;border-radius:8px;">
            Ver Entregas Finalizadas
          </a>
        </td></tr>
        <?php endif; ?>
      </table>

      <!-- Footer institucional -->
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#efeef0;">
        <tr><td align="center" style="padding:14px 12px;">
          <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#666;">
            © {$year_h} SEIEM – Servicios Educativos Integrados al Estado de México.
          </div>
          <div style="font:12px 'Segoe UI',Arial,Helvetica,sans-serif;color:#868686;">
            Este es un mensaje automático. No respondas.
          </div>
        </td></tr>
      </table>

      <!-- Barra inferior -->
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#2b0a16;">
        <tr><td style="height:8px;line-height:8px;font-size:0;">&nbsp;</td></tr>
      </table>

    </td></tr>
  </table>
</body>
</html>
HTML;
