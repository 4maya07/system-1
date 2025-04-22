<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../../conexion/conexion.php';

if (isset($conn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recoger los datos del formulario (sin el ID)
        $registro = $_POST['registro'];
        $nombre = $_POST['nombre'];
        $dui = $_POST['dui'] ?? null;
        $edad = $_POST['edad'] ?? null;
        $pasaporte = $_POST['pasaporte'] ?? null;
        $nit = $_POST['nit'] ?? null;
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $nombre_comercial = $_POST['nombre_comercial'] ?? null;
        $registro_iva = $_POST['registro_iva'] ?? null;
        $giro = $_POST['giro'] ?? null;
        $fechaRegistro = $_POST['fechaRegistro'];

        $tipoCliente = 'CONTRIBUYENTE NATURAL';

        // Procesar la fotografía si se subió
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
                NumeroRegistro, TipoCliente, NombreCompleto_NombreLegal_NombreOficial,
                NombreComercial, Fotografia, Edad, DUI, Pasaporte, DireccionFiscal,
                Telefono, CorreoElectronico, NIT, RegistroIVA, GiroActividadEconomica,
                FechaRegistro
            ) VALUES (
                :registro, :tipoCliente, :nombre,
                :nombre_comercial, :fotografia, :edad, :dui, :pasaporte, :direccion,
                :telefono, :correo, :nit, :registro_iva, :giro,
                :fechaRegistro
            )");

            $stmt->bindParam(':registro', $registro);
            $stmt->bindParam(':tipoCliente', $tipoCliente);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':nombre_comercial', $nombre_comercial);
            $stmt->bindParam(':fotografia', $fotografia);
            $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
            $stmt->bindParam(':dui', $dui);
            $stmt->bindParam(':pasaporte', $pasaporte);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nit', $nit);
            $stmt->bindParam(':registro_iva', $registro_iva);
            $stmt->bindParam(':giro', $giro);
            $stmt->bindParam(':fechaRegistro', $fechaRegistro);

            if ($stmt->execute()) {
                header("Location: ../cliente.html");
                exit();
            } else {
                echo "Error al registrar el cliente.";
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
