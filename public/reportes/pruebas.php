<?php
// test_jasper_random_pdf.php
// Genera un PDF con JasperReports sin JDBC (usa JREmptyDataSource)

$DEBUG = isset($_GET['debug']) && $_GET['debug'] == '1';
set_time_limit(0);

try {
  include('http://10.15.10.41:8080/JavaBridge/java/Java.inc');

  // ====== Datos al azar ======
  $folio = "TST-" . strtoupper(substr(md5(uniqid('', true)), 0, 10));
  $fecha = date('Y-m-d H:i:s');
  $r1 = random_int(1000, 9999);
  $r2 = random_int(1000, 9999);
  $r3 = random_int(1000, 9999);

  // ====== JRXML mínimo (sin query) ======
  $jrxml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<jasperReport xmlns="http://jasperreports.sourceforge.net/jasperreports"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://jasperreports.sourceforge.net/jasperreports http://jasperreports.sourceforge.net/xsd/jasperreport.xsd"
  name="random_test" pageWidth="595" pageHeight="842" columnWidth="555" leftMargin="20" rightMargin="20" topMargin="20" bottomMargin="20">

  <parameter name="pTitulo" class="java.lang.String"/>
  <parameter name="pFolio" class="java.lang.String"/>
  <parameter name="pFecha" class="java.lang.String"/>
  <parameter name="pR1" class="java.lang.String"/>
  <parameter name="pR2" class="java.lang.String"/>
  <parameter name="pR3" class="java.lang.String"/>

  <title>
    <band height="90">
      <staticText>
        <reportElement x="0" y="0" width="555" height="24"/>
        <textElement><font size="16" isBold="true"/></textElement>
        <text><![CDATA[PRUEBA JASPER SIN BD]]></text>
      </staticText>

      <textField>
        <reportElement x="0" y="32" width="555" height="18"/>
        <textElement><font size="12" isBold="true"/></textElement>
        <textFieldExpression><![CDATA[$P{pTitulo}]]></textFieldExpression>
      </textField>

      <textField>
        <reportElement x="0" y="55" width="555" height="16"/>
        <textFieldExpression><![CDATA["Folio: " + $P{pFolio} + "   Fecha: " + $P{pFecha}]]></textFieldExpression>
      </textField>
    </band>
  </title>

  <detail>
    <band height="120">
      <staticText>
        <reportElement x="0" y="0" width="555" height="18"/>
        <textElement><font size="12" isBold="true"/></textElement>
        <text><![CDATA[Valores aleatorios]]></text>
      </staticText>

      <textField>
        <reportElement x="0" y="28" width="555" height="16"/>
        <textFieldExpression><![CDATA["R1: " + $P{pR1}]]></textFieldExpression>
      </textField>
      <textField>
        <reportElement x="0" y="48" width="555" height="16"/>
        <textFieldExpression><![CDATA["R2: " + $P{pR2}]]></textFieldExpression>
      </textField>
      <textField>
        <reportElement x="0" y="68" width="555" height="16"/>
        <textFieldExpression><![CDATA["R3: " + $P{pR3}]]></textFieldExpression>
      </textField>

      <staticText>
        <reportElement x="0" y="95" width="555" height="16"/>
        <text><![CDATA[Si ves esto en PDF, Jasper + JavaBridge están OK.]]></text>
      </staticText>
    </band>
  </detail>

</jasperReport>
XML;

  // ====== Crear archivos temporales ======
  $tmpDir = sys_get_temp_dir();
  $base = $tmpDir . "/jasper_random_" . uniqid();
  $jrxmlPath = $base . ".jrxml";
  $jasperPath = $base . ".jasper";

  if (file_put_contents($jrxmlPath, $jrxml) === false) {
    throw new Exception("No pude escribir JRXML en: " . $jrxmlPath);
  }

  // ====== Compilar JRXML -> JASPER (sin iReport) ======
  $compile = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
  $compile->compileReportToFile($jrxmlPath, $jasperPath);

  // ====== Parámetros ======
  $params = new Java("java.util.HashMap");
  $params->put("pTitulo", "Reporte de prueba (sin JDBC)");
  $params->put("pFolio", $folio);
  $params->put("pFecha", $fecha);
  $params->put("pR1", (string)$r1);
  $params->put("pR2", (string)$r2);
  $params->put("pR3", (string)$r3);

  // ====== Llenar con datasource vacío ======
  $fill = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
  $ds = new Java("net.sf.jasperreports.engine.JREmptyDataSource", 1);
  $print = $fill->fillReport($jasperPath, $params, $ds);

  // ====== Exportar a PDF (byte[]) ======
  $export = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
  $pdfBytes = $export->exportReportToPdf($print);
  $pdf = java_values($pdfBytes);

  if ($DEBUG) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "OK\n";
    echo "JRXML: $jrxmlPath\nJASPER: $jasperPath\n";
    echo "PDF bytes: " . strlen($pdf) . "\n";
    exit;
  }

  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename="TEST_JASPER_RANDOM.pdf"');
  header('Content-Length: ' . strlen($pdf));
  header('Cache-Control: no-store, no-cache, must-revalidate');
  echo $pdf;

} catch (JavaException $ex) {
  http_response_code(500);
  header('Content-Type: text/plain; charset=utf-8');
  echo "JAVA EXCEPTION\n";
  echo $ex . "\n";
  if (function_exists('java_last_exception_get')) {
    $last = java_last_exception_get();
    if ($last) echo "\n-- java_last_exception_get() --\n" . $last . "\n";
  }
} catch (Throwable $ex) {
  http_response_code(500);
  header('Content-Type: text/plain; charset=utf-8');
  echo "PHP EXCEPTION\n";
  echo "Mensaje: " . $ex->getMessage() . "\n";
  echo "Archivo: " . $ex->getFile() . "\n";
  echo "Línea: " . $ex->getLine() . "\n";
}
