<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Guardar el nombre del usuario en una variable antes de cerrar la sesión
$username = $_SESSION['username'];

// Cerrar la sesión
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h1 {
            font-size: 24px;
        }
        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>¡Hasta pronto, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Has cerrado sesión exitosamente.</p>
    <button onclick="location.href='newsession.html'">Iniciar sesión</button>
</body>
</html>
