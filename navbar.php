<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<div class="navbar">
    <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <button onclick="location.href='settings.html'">Ajustes</button>
    <button onclick="location.href='logout.php'">Logout</button>
</div>
