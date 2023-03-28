<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
  </head>
  <body>
    <?php if (isset($_GET["username"])): ?>
      <!-- Si se ha proporcionado el nombre de usuario, mostrar página de bienvenida -->
      <h1>Bienvenido, <?php echo $_GET["username"]; ?>!</h1>
      <p>Esta es la página de bienvenida.</p>
    <?php else: ?>
      <!-- Si no se ha proporcionado el nombre de usuario, redirigir al inicio de sesión -->
      <?php header("Location: index.php"); exit(); ?>
    <?php endif; ?>
  </body>
</html>
