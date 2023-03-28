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
            display: block;
            color: white;
            text-align: right;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
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
    <div class="navbar">
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
    <h1>Menú</h1>
    <div class="menu">
        <button onclick="location.href='signup.html'">Crear Usuario</button>
        <button onclick="location.href='createItem.html'">Crear Artículo</button>
        <button onclick="location.href='findItem.html'">Buscar Categoría</button>
        <button onclick="location.href='createCategory.html'">Crear Categoría</button>
        <button onclick="location.href='buscar_categoria.html'">Buscar Categoría</button>
    </div>
</body>
</html>

