<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../../conexion/conexion.php';

if (isset($conn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recoger los datos del formulario

        $numero_registro = $_POST['registro'] ?? null;
        $nombre_completo = $_POST['nombre'] ?? null;
        $dui = $_POST['dui'] ?? null;
        $pasaporte = $_POST['pasaporte'] ?? null;
        $nit = $_POST['nit'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $telefono = $_POST['telefono'] ?? null;
        $correo = $_POST['correo'] ?? null;
        $fechaRegistro = date('Y-m-d');
        $tipoCliente = 'SUJETO EXCLUIDO PERSONA NATURAL';

        // Procesar la fotografía
        $fotografia = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($_FILES['foto']['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $fotografia = $rutaDestino;
            } else {
                echo "Error al subir la fotografía.";
                exit;
            }
        }

        try {
            $stmt = $conn->prepare("INSERT INTO tb_cliente (
                NumeroRegistro,
                TipoCliente,
                NombreCompleto_NombreLegal_NombreOficial,
                Fotografia,
                DUI,
                Pasaporte,
                Direccion,
                Telefono,
                CorreoElectronico,
                NIT,
                FechaRegistro
            ) VALUES (
                :numero_registro,
                :tipo_cliente,
                :nombre_completo,
                :fotografia,
                :dui,
                :pasaporte,
                :direccion,
                :telefono,
                :correo,
                :nit,
                :fecha_registro
            )");

            $stmt->bindParam(':numero_registro', $numero_registro);
            $stmt->bindParam(':tipo_cliente', $tipoCliente);
            $stmt->bindParam(':nombre_completo', $nombre_completo);
            $stmt->bindParam(':fotografia', $fotografia);
            $stmt->bindParam(':dui', $dui);
            $stmt->bindParam(':pasaporte', $pasaporte);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nit', $nit);
            $stmt->bindParam(':fecha_registro', $fechaRegistro);

            if ($stmt->execute()) {
                header("Location: ../cliente.html");
                exit();
            } else {
                echo "Error al registrar el cliente.";
                print_r($stmt->errorInfo()); // Para depurar errores de la base de datos
            }

        } catch (PDOException $e) {
            echo "Error de base de datos: " . $e->getMessage();
        }

        $conn = null;
    } else {
        echo "Acceso no permitido.";
    }
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
?>