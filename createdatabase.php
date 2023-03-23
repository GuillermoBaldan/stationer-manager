<?php

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "papeleria";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
    echo("<h2>Error de conexión</h2>s");
}

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS papeleria CHARACTER SET utf8;";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos 'papeleria' creada correctamente<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar base de datos
$conn->select_db($dbname);

// Crear tabla Categoria si no existe
$sql = "CREATE TABLE IF NOT EXISTS Categoria (
  id_categoria INT PRIMARY KEY,
  nombre_categoria VARCHAR(50)
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Categoria' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Categoria': " . $conn->error;
}

// Crear tabla Articulo si no existe
$sql = "CREATE TABLE IF NOT EXISTS Articulo (
    id_articulo INT PRIMARY KEY,
    nombre_articulo VARCHAR(50),
    descripcion_articulo VARCHAR(255),
    precio_articulo DECIMAL(10,2),
    stock_articulo INT,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria)
    );";
    if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Articulo' creada correctamente<br>";
    } else {
    echo "Error al crear la tabla 'Articulo': " . $conn->error;
    }
    
    // Crear tabla Usuario si no existe
    $sql = "CREATE TABLE IF NOT EXISTS Usuario (
    id_usuario INT PRIMARY KEY,
    nombre_usuario VARCHAR(50),
    correo_usuario VARCHAR(50),
    direccion_usuario VARCHAR(255)
    );";
    if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Usuario' creada correctamente<br>";
    } else {
    echo "Error al crear la tabla 'Usuario': " . $conn->error;
    }
    
    // Cerrar conexión
    $conn->close();
    
    ?>

    

