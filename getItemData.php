<?php
header("Content-Type: application/json");

// Conexión a la base de datos
require 'db_config.php';

// Obtener el ID del artículo
$id_articulo = $_GET['id_articulo'];

// Consultar la tabla 'Articulo' para obtener los datos del artículo
$sql = "SELECT * FROM Articulo WHERE id_articulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_articulo);
$stmt->execute();
$result = $stmt->get_result();

// Devolver los datos del artículo en formato JSON
if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(array('error' => 'No se encontró el artículo.'));
}

$stmt->close();
$conn->close();
?>
