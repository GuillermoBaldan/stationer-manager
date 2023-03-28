<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener datos del formulario
$user = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

// Validar datos del formulario
if ($password != $confirm_password) {
    echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    exit();
}

// Encriptar contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar datos en la base de datos
$sql = "INSERT INTO Usuario (nombre_usuario, correo_usuario, contraseña_usuario) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la sentencia fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la sentencia SQL: " . $conn->error);
}

$stmt->bind_param("sss", $user, $email, $password_hash);

if ($stmt->execute()) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
