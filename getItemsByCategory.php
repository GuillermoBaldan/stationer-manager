<?php
header('Content-Type: application/json');
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
    
    //echo "El id mandando es ".$id_categoria
    echo json_encode(['articulos' => $articulos]);
    //echo json_encode(['articulos' => $_GET['id_categoria']]);
    // Eliminada la línea innecesaria de "echo" aquí
} else {
    echo json_encode(['error' => 'No se proporcionó el ID de la categoría.']);
    // Eliminada la línea innecesaria de "echo" aquí
    }
    ?>