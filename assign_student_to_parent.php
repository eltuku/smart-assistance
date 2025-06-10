<?php
// Script para asignar un estudiante a un padre
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Student.php';

$userModel = new User();
$studentModel = new Student();

// Obtener todos los padres
$database = new Database();
$conn = $database->getConnection();

echo "<h2>Asignar Estudiante a Padre</h2>";

// Mostrar padres disponibles
$query = "SELECT id, username, email FROM users WHERE role = 'padre'";
$stmt = $conn->prepare($query);
$stmt->execute();
$parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Padres disponibles:</h3>";
foreach ($parents as $parent) {
    echo "ID: {$parent['id']} - Usuario: {$parent['username']} - Email: {$parent['email']}<br>";
}

// Mostrar estudiantes disponibles
$students = $studentModel->getAll();
echo "<h3>Estudiantes disponibles:</h3>";
foreach ($students as $student) {
    echo "ID: {$student['id']} - {$student['first_name']} {$student['last_name']}<br>";
}

// Formulario para asignar
echo "<h3>Asignar Estudiante a Padre:</h3>";
echo '<form method="POST">
    <label>ID del Padre: <input type="number" name="parent_id" required></label><br><br>
    <label>ID del Estudiante: <input type="number" name="student_id" required></label><br><br>
    <button type="submit" name="assign">Asignar</button>
</form>';

// Procesar asignación
if (isset($_POST['assign'])) {
    $parentId = $_POST['parent_id'];
    $studentId = $_POST['student_id'];
    
    // Verificar que el padre existe
    $parent = $userModel->getById($parentId);
    if (!$parent || $parent['role'] !== 'padre') {
        echo "<p style='color: red;'>Error: El ID del padre no es válido o no tiene rol de padre.</p>";
    } else {
        // Verificar que el estudiante existe
        $student = $studentModel->getById($studentId);
        if (!$student) {
            echo "<p style='color: red;'>Error: El ID del estudiante no es válido.</p>";
        } else {
            // Realizar la asignación
            if ($userModel->assignStudentToParent($parentId, $studentId)) {
                echo "<p style='color: green;'>¡Estudiante asignado correctamente!</p>";
                echo "<p>Padre: {$parent['username']} ahora puede ver la información de {$student['first_name']} {$student['last_name']}</p>";
            } else {
                echo "<p style='color: red;'>Error al asignar el estudiante. Puede que ya esté asignado.</p>";
            }
        }
    }
}

// Mostrar asignaciones actuales
echo "<h3>Asignaciones actuales:</h3>";
$query = "SELECT u.username, u.email, s.first_name, s.last_name, c.name as course_name
          FROM users u
          JOIN parent_student ps ON u.id = ps.parent_user_id
          JOIN students s ON ps.student_id = s.id
          LEFT JOIN courses c ON s.course_id = c.id
          WHERE u.role = 'padre'
          ORDER BY u.username, s.last_name";
$stmt = $conn->prepare($query);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($assignments)) {
    echo "<p>No hay asignaciones actuales.</p>";
} else {
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>Padre (Usuario)</th>
                <th>Email</th>
                <th>Estudiante</th>
                <th>Curso</th>
            </tr>";
    foreach ($assignments as $assignment) {
        echo "<tr>
                <td>{$assignment['username']}</td>
                <td>{$assignment['email']}</td>
                <td>{$assignment['first_name']} {$assignment['last_name']}</td>
                <td>{$assignment['course_name']}</td>
              </tr>";
    }
    echo "</table>";
}
?>
