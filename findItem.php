<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener datos del formulario
$palabra_busqueda = $_POST['palabra'];

// Consultar la tabla 'Articulo' para buscar artículos por nombre
$sql = "SELECT * FROM Articulo WHERE nombre_articulo LIKE ?";
$stmt = $conn->prepare($sql);
$search_param = "%" . $palabra_busqueda . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Generar tabla HTML con los resultados
echo "<table id='resultTable' border='1'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Número de unidades</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr data-id='" . $row['id_articulo'] . "'>
            <td>" . $row['id_articulo'] . "</td>
            <td>" . $row['nombre_articulo'] . "</td>
            <td>" . $row['descripcion_articulo'] . "</td>
            <td>" . $row['precio_articulo'] . "</td>
            <td>" . $row['stock_articulo'] . "</td>
            <td>" . $row['id_categoria'] . "</td>
          </tr>";
}

echo "</tbody></table>";

$stmt->close();
$conn->close();
?>

<script>
// Añadir controlador de eventos para detectar clics en las filas de la tabla
document.getElementById('resultTable').addEventListener('click', function(event) {
    var target = event.target;
    while (target && target.nodeName !== 'TR') {
        target = target.parentNode;
    }
    if (target) {
        var id_articulo = target.getAttribute('data-id');
        window.location.href = 'updateItem.html?id_articulo=' + id_articulo;
    }
});
</script>
