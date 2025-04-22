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
        $edad = $_POST['edad'] ?? null;
        $representante_legal = $_POST['representante'] ?? null;
        $profesion = $_POST['profesion'] ?? null;
        $empresa_pertenece = $_POST['empresa'] ?? null;
        $correo_electronico = $_POST['correo'] ?? null;
        $telefono = $_POST['telefono'] ?? null;
        $dui = $_POST['dui'] ?? null;
        $pasaporte = $_POST['pasaporte'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $fecha_registro = $_POST['fechaRegistro'] ?? null;
        $tipoCliente = 'CONSUMIDOR';

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
                Edad,
                RepresentanteLegal,
                Profesion,
                EmpresaPertenece,
                CorreoElectronico,
                Telefono,
                DUI,
                Pasaporte,
                Direccion,
                FechaRegistro
            ) VALUES (
                :numero_registro,
                :tipo_cliente,
                :nombre_completo,
                :fotografia,
                :edad,
                :representante_legal,
                :profesion,
                :empresa_pertenece,
                :correo_electronico,
                :telefono,
                :dui,
                :pasaporte,
                :direccion,
                :fecha_registro
            )");

            $stmt->bindParam(':numero_registro', $numero_registro);
            $stmt->bindParam(':tipo_cliente', $tipoCliente);
            $stmt->bindParam(':nombre_completo', $nombre_completo);
            $stmt->bindParam(':fotografia', $fotografia);
            $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
            $stmt->bindParam(':representante_legal', $representante_legal);
            $stmt->bindParam(':profesion', $profesion);
            $stmt->bindParam(':empresa_pertenece', $empresa_pertenece);
            $stmt->bindParam(':correo_electronico', $correo_electronico);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':dui', $dui);
            $stmt->bindParam(':pasaporte', $pasaporte);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':fecha_registro', $fecha_registro);

            if ($stmt->execute()) {
                echo "Cliente Consumidor registrado con éxito.";
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