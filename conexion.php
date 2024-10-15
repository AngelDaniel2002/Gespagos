<?php
$host = 'localhost'; // Cambia si es necesario
$db = 'gestpagos'; // Nombre de la base de datos
$user = 'root'; // Cambia según tu configuración
$pass = '12345'; // Cambia según tu configuración

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
