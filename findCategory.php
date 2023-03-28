<?php
// Conexión a la base de datos
require 'db_config.php';

// Obtener datos del formulario
$palabra_busqueda = $_POST['palabra'];

// Consultar la tabla 'Categoria' para buscar categorías por nombre
$sql = "SELECT * FROM Categoria WHERE nombre_categoria LIKE ?";
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
                <th>Nombre de categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr data-id='" . $row['id_categoria'] . "'>
            <td>" . $row['id_categoria'] . "</td>
            <td>" . $row['nombre_categoria'] . "</td>
            <td>
                <button onclick='updateCategory(" . $row['id_categoria'] . ")'>Actualizar</button>
                <button onclick='deleteCategory(" . $row['id_categoria'] . ")'>Eliminar</button>
            </td>
          </tr>";
}

echo "</tbody></table>";

$stmt->close();
$conn->close();
?>

<script>
function updateCategory(id_categoria) {
    window.location.href = 'updateCategory.html?id_categoria=' + id_categoria;
}

function deleteCategory(id_categoria) {
    if (confirm('¿Está seguro de que desea eliminar esta categoría?')) {
        window.location.href = 'deleteCategory.php?id_categoria=' + id_categoria;
    }
}
</script>
