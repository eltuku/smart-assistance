<?php
require_once 'config/database.php';
require_once 'models/Student.php';

$studentModel = new Student();
$students = $studentModel->getAll();

echo "Estudiantes en la base de datos:\n";
echo "Total: " . count($students) . "\n\n";

foreach ($students as $student) {
    echo "ID: " . $student['id'] . "\n";
    echo "Nombre: '" . $student['first_name'] . "'\n";
    echo "Apellido: '" . $student['last_name'] . "'\n";
    echo "Email: '" . $student['email'] . "'\n";
    echo "Curso: " . $student['course_name'] . "\n";
    echo "---\n";
}
?>
