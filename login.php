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

// Crear conexión
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verificar conexión
if ($conn->connect_error)
{
    die("Error de conexión: " . $conn->connect_error);
}
    
// Consultar la tabla 'Usuario' para verificar si el usuario y la contraseña coinciden
$sql = "SELECT * FROM Usuario WHERE nombre_usuario = ? AND contraseña_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
    
if ($result->num_rows > 0) {
    // Iniciar sesión exitosamente
    echo "Bienvenido, " . $username . "!";
} else {
    // Mostrar mensaje de error
    echo "Nombre de usuario o contraseña incorrectos.";
    // Redirigir a la página de registro 'signup.html'
    header("Location: signup.html");
    exit();
}
    
// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
