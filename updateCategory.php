<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener los datos enviados desde el formulario
$id_categoria = $_POST['id_categoria'];
$nombre_categoria = $_POST['nombre_categoria'];

// Preparar y ejecutar la consulta para actualizar la categoría
$sql = "UPDATE Categoria SET nombre_categoria = ? WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nombre_categoria, $id_categoria);

if ($stmt->execute()) {
    header("Location: mainmenu.php"); // Redireccionar a una página de éxito
} else {
    header("Location: errorPage.html"); // Redireccionar a una página de error
}
    
$stmt->close();
$conn->close();
?>
