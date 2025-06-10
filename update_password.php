<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$newPassword = 'admin123'; // Cambia esta contraseña por la que desees
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$username = 'admin';

$query = "UPDATE users SET password = :password WHERE username = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':username', $username);

if ($stmt->execute()) {
    echo "Contraseña actualizada correctamente.";
} else {
    echo "Error al actualizar la contraseña.";
}
?>
