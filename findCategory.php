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
            </tr>
        </thead>
        <tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr data-id='" . $row['id_categoria'] . "'>
            <td>" . $row['id_categoria'] . "</td>
            <td>" . $row['nombre_categoria'] . "</td>
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
        var id_categoria = target.getAttribute('data-id');
        window.location.href = 'updateCategory.html?id_categoria=' + id_categoria;
    }
});
</script>
