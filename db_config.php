<?php
$servername = "your_database_host";
$username = "root";
$password = "";
$dbname = "papeleria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
