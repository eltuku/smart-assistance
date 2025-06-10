<?php
require_once 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

$logFile = 'pdf_test.log';
file_put_contents($logFile, "Iniciando prueba simple\n");

try {
    $pdfFiles = glob('uploads/*.pdf');
    if (empty($pdfFiles)) {
        file_put_contents($logFile, "No hay PDFs\n", FILE_APPEND);
        exit;
    }
    
    $pdfFile = $pdfFiles[0];
    file_put_contents($logFile, "Archivo: $pdfFile\n", FILE_APPEND);
    
    $parser = new Parser();
    $pdf = $parser->parseFile($pdfFile);
    
    $pages = $pdf->getPages();
    file_put_contents($logFile, "Páginas: " . count($pages) . "\n", FILE_APPEND);
    
    foreach ($pages as $page) {
        $text = $page->getText();
        file_put_contents($logFile, "Texto extraído:\n" . $text . "\n", FILE_APPEND);
        break; // Solo primera página
    }
    
} catch (Exception $e) {
    file_put_contents($logFile, "Error: " . $e->getMessage() . "\n", FILE_APPEND);
}
?>
