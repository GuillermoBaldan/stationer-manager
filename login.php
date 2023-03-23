<?php
// Comprobar si la base de datos 'papeleria' existe
function check_database($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SHOW DATABASES LIKE '$dbname';";
    $result = $conn->query($sql);
    $conn->close();

    return ($result->num_rows > 0);
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "papeleria";

// Verificar si la base de datos existe
if (!check_database($servername, $db_username, $db_password, $dbname)) {
    // Ejecutar el script 'createdatabase.php' si la base de datos no existe
    include 'createdatabase.php';
}

// Obtener los valores del formulario
$username = $_POST["username"];
$password = $_POST["password"];

// Validar los valores del formulario
if ($username == "usuario" && $password == "contraseña") {
// Iniciar sesión exitosamente
echo "Bienvenido, " . $username . "!";
} else {
// Mostrar mensaje de error
echo "Nombre de usuario o contraseña incorrectos.";
}
?>
