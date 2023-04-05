<?php
// Conexión a la base de datos
require 'db_config.php';
// Obtener datos del formulario
$palabra_busqueda = isset($_POST['palabra']) ? $_POST['palabra'] : '';
// Consultar la tabla 'Categoria' para buscar categorías por nombre
$sql = "SELECT * FROM Categoria WHERE nombre_categoria LIKE ?";
$stmt = $conn->prepare($sql);
$search_param = "%" . $palabra_busqueda . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
// Generar tabla HTML con los resultados
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Buscar Categorías</title>
    <link rel='stylesheet' href='style/findCategory.css'> 
</head>
<body>";
include 'components/navbar.php';
echo "
    <h1>Buscar Categorías</h1>
    <form method='POST' action='findCategory.php'>
        <label for='palabra'>Palabra clave:</label>
        <input type='text' id='palabra' name='palabra' value='" . $palabra_busqueda . "' required>
        <button type='submit'>Buscar</button>
    </form>";
if ($palabra_busqueda != '') {
    if ($result->num_rows > 0) {
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
                    echo "<tr data-id='" . $row['id_categoria'] . "' onclick='showArticulos(" . $row['id_categoria'] . ")'>
                            <td>" . $row['id_categoria'] . "</td>
                            <td>" . $row['nombre_categoria'] . "</td>
                            <td>
                                <button onclick='event.stopPropagation(); updateCategory(" . $row['id_categoria'] . ")'>Actualizar</button>
                                <button onclick='event.stopPropagation(); showArticulosByCategory(" . $row['id_categoria'] . ")'>Eliminar</button>
                            </td>
                          </tr>";
                }
                
        echo "</tbody></table>";
    } else {
        echo "<p>No se encontraron resultados para la búsqueda.</p>";
    }
}
echo "<script>
function showArticulosByCategory(id_categoria) {
    fetch(`getItemsByCategory.php?id_categoria=` + id_categoria)
        .then(response => response.json())
        .then(data => {
            if (data.articulos.length > 0) {
                console.log('Artículos en la categoría:', data.articulos);
            } else {
                console.log('No hay artículos en esta categoría.');
                console.log(data);
            }
        })
        .catch(error => console.error('Error:', error));
}

</script>
";

    echo "</body>

    </html>";
    include 'components/mainMenuButton.php';
    $stmt->close();
    $conn->close();
    ?>