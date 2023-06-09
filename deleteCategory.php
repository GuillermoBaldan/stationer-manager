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
    
            // Reemplaza el bloque 'while' existente con este código
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['id_categoria'] . "' onclick='showArticulos(" . $row['id_categoria'] . ")'>
                        <td>" . $row['id_categoria'] . "</td>
                        <td>" . $row['nombre_categoria'] . "</td>
                        <td>
                            <button onclick='updateCategory(" . $row['id_categoria'] . ")'>Actualizar</button>
                            <button onclick='deleteCategory(" . $row['id_categoria'] . ")'>Eliminar</button>
                        </td>
                      </tr>";
            }
    
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados para la búsqueda.</p>";
        }
    }

echo "</body>
</html>";
include 'components/mainMenuButton.php';

$stmt->close();
$conn->close();
?>

<script>
function updateCategory(id_categoria) {
    window.location.href = 'updateCategory.html?id_categoria=' + id_categoria;
}

function deleteCategory(id_categoria) {
    if (confirm('¿Está seguro de que desea eliminar esta categoría?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "deleteCategory.php?id_categoria=" + id_categoria, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        alert(response.error);
                    } else {
                        let articulosTable = createArticulosTable(response.articulos);
                        let container = document.createElement('div');
                        container.innerHTML = `
                            <h2>Artículos en la categoría seleccionada</h2>
                            <p>A continuación se muestran los artículos que pertenecen a la categoría seleccionada:</p>
                        `;
                        container.appendChild(articulosTable);
                        
                        let resultTable = document.getElementById('resultTable');
                        if (resultTable) {
                            resultTable.parentNode.insertBefore(container, resultTable.nextSibling);
                        } else {
                            document.body.appendChild(container);
                        }
                    }
                } catch (e) {
                    alert('Categoría eliminada exitosamente.');
                    location.reload();
                }
            }
        };
        xhr.send();
    }
}


function showArticulosRelacionados(articulos) {
    let table = document.createElement('table');
table.border = '1';
table.innerHTML = <thead> <tr> <th>ID Artículo</th> <th>Nombre</th> <th>Descripción</th> <th>Precio Unitario</th> <th>Número de unidades</th> <th>Categoría</th> <th>Imagen</th> </tr> </thead> <tbody> </tbody> ;
let tbody = table.querySelector('tbody');
for (let i = 0; i < articulos.length; i++) {
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${articulos[i].id_articulo}</td>
        <td>${articulos[i].nombre_articulo}</td>
        <td>${articulos[i].descripcion}</td>
        <td>${articulos[i].precio}</td>
        <td>${articulos[i].stock_articulo}</td>
        <td>${articulos[i].id_categoria}</td>
        <td><img src='${articulos[i].foto_articulo_url}' alt='Imagen de artículo' style='max-width: 100px; max-height: 100px;'></td>
    `;
    tbody.appendChild(tr);
}

let container = document.createElement('div');
container.innerHTML = `
    <h2>Artículos relacionados</h2>
    <p>Por favor, elimine los siguientes artículos antes de eliminar la categoría:</p>
`;
container.appendChild(table);

let resultTable = document.getElementById('resultTable');
if (resultTable) {
    resultTable.parentNode.insertBefore(container, resultTable.nextSibling);
} else {
    document.body.appendChild(container);
}
}

function showArticulos(id_categoria) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "getItemsByCategory.php?id_categoria=" + id_categoria, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            let articulosTable = createArticulosTable(response.articulos);
            let container = document.createElement('div');
            container.innerHTML = `
                <h2>Artículos en la categoría seleccionada</h2>
                <p>A continuación se muestran los artículos que pertenecen a la categoría seleccionada:</p>
            `;
            container.appendChild(articulosTable);
            
            let resultTable = document.getElementById('resultTable');
            if (resultTable) {
                resultTable.parentNode.insertBefore(container, resultTable.nextSibling);
            } else {
                document.body.appendChild(container);
            }
        }
    };
    xhr.send();
}


function createArticulosTable(articulos) {
    let table = document.createElement('table');
    table.border = '1';
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID Artículo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Número de unidades</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    `;

    let tbody = table.querySelector('tbody');
    for (let i = 0; i < articulos.length; i++) {
        let tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${articulos[i].id_articulo}</td>
            <td>${articulos[i].nombre_articulo}</td>
            <td>${articulos[i].descripcion}</td>
            <td>${articulos[i].precio}</td>
            <td>${articulos[i].stock_articulo}</td>
            <td><img src='${articulos[i].foto_articulo_url}' alt='Imagen de artículo' style='max-width: 100px; max-height: 100px;'></td>
        `;
        tbody.appendChild(tr);
    }

    return table;
}

</script>