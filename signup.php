<?php
// Conexión a la base de datos
require 'db_config.php';

// Verificar si se han enviado los datos del formulario
if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
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

        // Guardar usuario en el archivo usuarios.txt
        $usuarios_txt = "System-files/usuarios.txt";
        $usuario_info = $user . " - " . $email . PHP_EOL;

        if (file_put_contents($usuarios_txt, $usuario_info, FILE_APPEND)) {
            echo "Usuario guardado en usuarios.txt.";
        } else {
            echo "Error al guardar usuario en usuarios.txt.";
        }

        header("Location: mainMenu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style/signup.css"> 
</head>
<body>
    <?php include 'components/navbar.php'; ?>
    
    <div class="content">
        <h1>Registro de Usuario</h1>
        <form method="POST" action="signup.php">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm-password">Confirmar Contraseña:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            
            <button type="submit">Registrar Usuario</button>
            <?php include 'components/mainMenuButton.php'; ?>
        </form>
    </div>
</body>
</html>
