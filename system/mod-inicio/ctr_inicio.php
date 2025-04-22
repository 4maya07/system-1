<?php
session_start();
include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = trim($_POST["nombreUsuario"]);
    $contrasena = $_POST["contrasena"];

    try {
        // Buscar el usuario por nombre de usuario
        $stmt = $conn->prepare("SELECT * FROM tb_usuarios WHERE nombreUsuario = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe y las credenciales son correctas
        if ($usuario) {
            if ($contrasena === $usuario['contrasena']) { // Comparación directa sin cifrado
                $_SESSION['usuario_id'] = $usuario['idUsuario']; 
                $_SESSION['nombreUsuario'] = $usuario['nombreUsuario'];
                $_SESSION['cargo'] = $usuario['cargo'];
                echo "success"; // Credenciales correctas
            } else {
                echo "error"; // Contraseña incorrecta
            }
        } else {
            echo "error"; // Usuario no encontrado
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo "error";
    }
}

$conn = null;
?>
