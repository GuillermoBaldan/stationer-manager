<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener el ID de la categoría
$id_categoria = $_GET['id_categoria'];

// Eliminar la categoría de la tabla 'Categoria'
$sql = "DELETE FROM Categoria WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);

if ($stmt->execute()) {
    // Si la eliminación fue exitosa, redirigir al usuario a la página de inicio o a una página de éxito
    header("Location: mainmenu.php");
    exit();
} else {
    // Si hubo un error al eliminar la categoría, mostrar un mensaje de error
    echo "Error al eliminar la categoría: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
