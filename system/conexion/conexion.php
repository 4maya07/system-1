<?php
$servername = "localhost"; // O la dirección de tu servidor
$username = "root"; // Tu nombre de usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$dbname = "dbdycris";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexión exitosa"; // Descomenta para depurar
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>