<?php
// Conexión a la base de datos
require 'db_config.php';

if (isset($_POST['nombre'])) {
    // Obtener datos del formulario
    $nombre_articulo = $_POST['nombre'];
    $descripcion_articulo = $_POST['descripcion'];
    $precio_articulo = $_POST['precio_unitario'];
    $stock_articulo = $_POST['numero_unidades'];
    $nombre_categoria = $_POST['categoria'];

    // Buscar el id_categoria correspondiente al nombre de la categoría
    $sql = "SELECT id_categoria FROM Categoria WHERE nombre_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_categoria = $row['id_categoria'];
    } else {
        echo "Categoría no encontrada.";
        exit();
    }
    $stmt->close();

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
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Artículo de Inventario</title>
    <link rel="stylesheet" href="style/createItem.css"> 
</head>
<body>
    <?php include 'components/navbar.php'; ?>
    <h1>Crear Artículo de Inventario</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <label for="precio_unitario">Precio Unitario:</label>
    <input type="number" id="precio_unitario" name="precio_unitario" step="0.01" required>

    <label for="numero_unidades">Número de Unidades:</label>
    <input type="number" id="numero_unidades" name="numero_unidades" required>

    <label for="categoria">Categoría:</label>
    <input type="text" id="categoria" name="categoria" required>

    <button type="submit">Crear Artículo</button>
    <?php include 'components/mainMenuButton.php'; ?>
</form>
</body>
</html>
