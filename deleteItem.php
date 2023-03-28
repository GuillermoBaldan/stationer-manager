<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener el ID del artículo
$id_articulo = $_GET['id_articulo'];

// Eliminar el artículo de la tabla 'Articulo'
$sql = "DELETE FROM Articulo WHERE id_articulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_articulo);

if ($stmt->execute()) {
    // Si la eliminación fue exitosa, redirigir al usuario a la página de inicio o a una página de éxito
    header("Location: mainmenu.php");
    exit();
} else {
    // Si hubo un error al eliminar el artículo, mostrar un mensaje de error
    echo "Error al eliminar el artículo: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
