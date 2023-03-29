<?php
require 'db_config.php';

if (isset($_GET['id_categoria'])) {
    $id_categoria = $_GET['id_categoria'];

    $sql = "SELECT * FROM Articulo WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    $articulos = [];
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['articulos' => $articulos]);
} else {
    echo json_encode(['error' => 'No se proporcionó el ID de la categoría.']);
}
?>
