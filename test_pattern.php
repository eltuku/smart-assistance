<?php
$text = "1ALBARRACÌN AMIONE, Byron Mateo
2ALONSO, Nicolás Andrés
3AYALA, Agustín Franco
4BERJEL, Joaquín Nahuel
5CAFFERATA PAILLALEF, Lara Sol
6CARSETTI GRZELAK, Bruno
7D'AMORE, Morena
8DE SIMONE PENTIMALLI, Uma
9DEVANI, Sofía Belén
10DI PRINZIO, Benjamín";

$pattern = '/(\d+)([A-ZÁÉÍÓÚÑ][A-ZÁÉÍÓÚÑ\s\']+),\s*([A-Za-záéíóúñ][A-Za-záéíóúñ\s]+)(?:\r?\n|\s*$)/u';

if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
    file_put_contents('pattern_test.log', "Coincidencias encontradas: " . count($matches) . "\n");
    
    foreach ($matches as $i => $match) {
        $numero = trim($match[1]);
        $apellidos = trim($match[2]);
        $nombres = trim($match[3]);
        
        $info = "Match " . ($i + 1) . ": Número=$numero, Apellidos='$apellidos', Nombres='$nombres'\n";
        file_put_contents('pattern_test.log', $info, FILE_APPEND);
    }
} else {
    file_put_contents('pattern_test.log', "No se encontraron coincidencias\n");
}

// Probar con patrón más simple
$simplePattern = '/(\d+)([^,]+),\s*([^,\n\r]+)/u';
if (preg_match_all($simplePattern, $text, $matches2, PREG_SET_ORDER)) {
    file_put_contents('pattern_test.log', "\nPatrón simple - Coincidencias: " . count($matches2) . "\n", FILE_APPEND);
    
    foreach (array_slice($matches2, 0, 3) as $i => $match) {
        $numero = trim($match[1]);
        $apellidos = trim($match[2]);
        $nombres = trim($match[3]);
        
        $info = "Simple Match " . ($i + 1) . ": Número=$numero, Apellidos='$apellidos', Nombres='$nombres'\n";
        file_put_contents('pattern_test.log', $info, FILE_APPEND);
    }
}
?>
