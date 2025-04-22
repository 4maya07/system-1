<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../../conexion/conexion.php';

if (isset($conn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recoger los datos del formulario
        $registro_id = $_POST['id'] ?? null;
        $numero_registro = $_POST['registro'] ?? null;
        $nombre_oficial = $_POST['nombreLegal'] ?? null;
        $nombre_comercial = $_POST['nombreComercial'] ?? null;
        $nit = $_POST['nit'] ?? null;
        $registro_ong = $_POST['registroONG'] ?? null;
        $giro_actividad = $_POST['giro'] ?? null;
        $direccion_fiscal = $_POST['direccion'] ?? null;
        $telefono_empresa = $_POST['telefonoEmpresa'] ?? null;
        $correo_empresa = $_POST['correoEmpresa'] ?? null;
        $nombre_contacto = $_POST['contactoNombre'] ?? null;
        $dui_contacto = $_POST['duiContacto'] ?? null;
        $correo_contacto = $_POST['correoContacto'] ?? null;
        $telefono_contacto = $_POST['telefonoContacto'] ?? null;
        $nombre_representante = $_POST['repNombre'] ?? null;
        $ncr_representante = $_POST['repNcr'] ?? null;
        $dui_representante = $_POST['repDui'] ?? null;
        $pasaporte_representante = $_POST['repPasaporte'] ?? null;
        $cargo_representante = $_POST['repCargo'] ?? null;
        $telefono_representante = $_POST['repTelefono'] ?? null;
        $correo_representante = $_POST['repCorreo'] ?? null;
        $fechaRegistro = date('Y-m-d');
        $tipoCliente = 'SUJETO EXCLUIDO ONG';

        // Procesar el logo
        $fotografia = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($_FILES['logo']['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                $fotografia = $rutaDestino;
            } else {
                echo "Error al subir el logo.";
                exit;
            }
        }

        try {
            $stmt = $conn->prepare("INSERT INTO tb_cliente (
                NumeroRegistro,
                TipoCliente,
                NombreCompleto_NombreLegal_NombreOficial,
                NombreComercial,
                Fotografia,
                NIT,
                GiroActividadEconomica,
                DireccionFiscal,
                TelefonoEmpresa,
                CorreoElectronicoEmpresa,
                NombreContacto,
                DUIContacto,
                CorreoElectronicoContacto,
                TelefonoContacto,
                RepresentanteLegal,
                NCR,
                DUI,
                Pasaporte,
                Cargo,
                Telefono,
                CorreoElectronico,
                FechaRegistro,
                RegistroONG
            ) VALUES (
                :numero_registro,
                :tipo_cliente,
                :nombre_oficial,
                :nombre_comercial,
                :fotografia,
                :nit,
                :giro_actividad,
                :direccion_fiscal,
                :telefono_empresa,
                :correo_empresa,
                :nombre_contacto,
                :dui_contacto,
                :correo_contacto,
                :telefono_contacto,
                :nombre_representante,
                :ncr_representante,
                :dui_representante,
                :pasaporte_representante,
                :cargo_representante,
                :telefono_representante,
                :correo_representante,
                :fecha_registro,
                :registro_ong
            )");

            $stmt->bindParam(':numero_registro', $numero_registro);
            $stmt->bindParam(':tipo_cliente', $tipoCliente);
            $stmt->bindParam(':nombre_oficial', $nombre_oficial);
            $stmt->bindParam(':nombre_comercial', $nombre_comercial);
            $stmt->bindParam(':fotografia', $fotografia);
            $stmt->bindParam(':nit', $nit);
            $stmt->bindParam(':giro_actividad', $giro_actividad);
            $stmt->bindParam(':direccion_fiscal', $direccion_fiscal);
            $stmt->bindParam(':telefono_empresa', $telefono_empresa);
            $stmt->bindParam(':correo_empresa', $correo_empresa);
            $stmt->bindParam(':nombre_contacto', $nombre_contacto);
            $stmt->bindParam(':dui_contacto', $dui_contacto);
            $stmt->bindParam(':correo_contacto', $correo_contacto);
            $stmt->bindParam(':telefono_contacto', $telefono_contacto);
            $stmt->bindParam(':nombre_representante', $nombre_representante);
            $stmt->bindParam(':ncr_representante', $ncr_representante);
            $stmt->bindParam(':dui_representante', $dui_representante);
            $stmt->bindParam(':pasaporte_representante', $pasaporte_representante);
            $stmt->bindParam(':cargo_representante', $cargo_representante);
            $stmt->bindParam(':telefono_representante', $telefono_representante);
            $stmt->bindParam(':correo_representante', $correo_representante);
            $stmt->bindParam(':fecha_registro', $fechaRegistro);
            $stmt->bindParam(':registro_ong', $registro_ong);

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