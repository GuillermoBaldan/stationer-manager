<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener datos del formulario
$nombre_articulo = $_POST['nombre'];
$descripcion_articulo = $_POST['descripcion'];
$precio_articulo = $_POST['precio_unitario'];
$stock_articulo = $_POST['numero_unidades'];
$id_categoria = $_POST['categoria'];

// Procesar la imagen
$imagen = $_FILES['imagen'];
$nombre_imagen = basename($imagen['name']);
$directorio_destino = 'imagenes/';
$imagen_url = $directorio_destino . $nombre_imagen;

if (move_uploaded_file($imagen['tmp_name'], $imagen_url)) {
    // Insertar datos en la base de datos
    $sql = "INSERT INTO Articulo (nombre_articulo, descripcion_articulo, precio_articulo, stock_articulo, id_categoria, foto_articulo_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la sentencia SQL: " . $conn->error);
    }

    $stmt->bind_param("ssdiis", $nombre_articulo, $descripcion_articulo, $precio_articulo, $stock_articulo, $id_categoria, $imagen_url);

    if ($stmt->execute()) {
        echo "Artículo creado exitosamente.";
        header("Location: mainmenu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
} else {
    echo "Error al subir la imagen. Por favor, inténtalo de nuevo.";
}

$conn->close();
?>
