<?php
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
