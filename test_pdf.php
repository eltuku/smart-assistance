<?php
// Test simple para verificar que TCPDF funciona
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

try {
    // Crear nuevo documento PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Establecer información del documento
    $pdf->SetCreator('Sistema de Gestión Escolar');
    $pdf->SetAuthor('Sistema de Gestión');
    $pdf->SetTitle('Test PDF');

    // Establecer márgenes
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    // Establecer fuente
    $pdf->SetFont('helvetica', '', 12);

    // Agregar página
    $pdf->AddPage();

    // Contenido HTML de prueba
    $html = '
    <h1 style="color: #2c3e50; text-align: center;">Test PDF - Sistema Escolar</h1>
    <p>Este es un PDF de prueba generado con TCPDF.</p>
    <p><strong>Fecha:</strong> ' . date('d/m/Y H:i:s') . '</p>
    
    <table border="1" cellpadding="5">
        <tr style="background-color: #f4f4f4;">
            <th>Estudiante</th>
            <th>Asistencia</th>
            <th>Estado</th>
        </tr>
        <tr>
            <td>Juan Pérez</td>
            <td>95%</td>
            <td style="color: green;">Presente</td>
        </tr>
        <tr>
            <td>María García</td>
            <td>88%</td>
            <td style="color: orange;">Llegada tarde</td>
        </tr>
        <tr>
            <td>Carlos López</td>
            <td>75%</td>
            <td style="color: red;">Ausente</td>
        </tr>
    </table>
    
    <p style="text-align: center; margin-top: 30px; color: #666;">
        Reporte generado por el Sistema de Gestión Escolar
    </p>
    ';

    // Escribir HTML en el PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Generar PDF
    $pdf->Output('test_reporte.pdf', 'D');
    
} catch (Exception $e) {
    echo "Error generando PDF: " . $e->getMessage();
    echo "<br>Verifica que TCPDF esté instalado correctamente.";
}
?>
