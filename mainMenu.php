<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
        }
        .navbar span {
            display: inline-block;
            color: white;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
        }
        .navbar button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 14px 16px;
            text-align: center;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
        }
        .menu {
            margin-top: 100px;
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
    <?php include 'components/navbar.php'; ?>
    <h1>Menú</h1>
    <div class="menu">
        <button onclick="location.href='signup.html'">Crear Usuario</button>
        <button onclick="location.href='createItem.html'">Crear Artículo</button>
        <button onclick="location.href='findItem.php'">Buscar Artículo</button>
        <button onclick="location.href='createCategory.php'">Crear Categoría</button>
        <button onclick="location.href='findCategory.html'">Buscar Categoría</button>
    </div>
</body>
</html>
