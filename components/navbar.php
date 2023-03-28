<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar si la página de origen es newsession.html
$displayWelcomeMessage = false;
if (isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) == 'newsession.html') {
    $displayWelcomeMessage = true;
}
?>
<link rel="stylesheet" href="style/navbar.css">

<div class="navbar">
    <span>
        <?php if ($displayWelcomeMessage): ?>
            Bienvenido,
        <?php endif; ?>
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </span>
    <div class="button-container">
        <button onclick="location.href='settings.html'">Ajustes</button>
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
</div>
