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
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user, $email, $password_hash);

if ($stmt->execute()) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
