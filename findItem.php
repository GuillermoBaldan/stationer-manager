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
                <th>Imagen</th>
                <th>Acciones</th>
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
            <td><img src='" . $row['foto_articulo_url'] . "' alt='Imagen de artículo' style='max-width: 100px; max-height: 100px;'></td>
            <td>
                <button onclick='updateItem(" . $row['id_articulo'] . ")'>Actualizar</button>
                <button onclick='deleteItem(" . $row['id_articulo'] . ")'>Eliminar</button>
            </td>
          </tr>";
}

echo "</tbody></table>";

$stmt->close();
$conn->close();
?>

<script>
function updateItem(id_articulo) {
    window.location.href = 'updateItem.html?id_articulo=' + id_articulo;
}

function deleteItem(id_articulo) {
    if (confirm('¿Está seguro de que desea eliminar este artículo?')) {
        window.location.href = 'deleteItem.php?id_articulo=' + id_articulo;
    }
}
</script>
