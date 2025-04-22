<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión a la base de datos
include '../../conexion/conexion.php';

if (isset($conn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recoger los datos del formulario de contribuyente jurídico
        $registro = $_POST['registro'] ?? null;
        $nombre_legal = $_POST['nombre_legal'] ?? null;
        $nombre_comercial = $_POST['nombre_comercial'] ?? null;
        $nit = $_POST['nit'] ?? null;
        $registro_iva = $_POST['registro_iva'] ?? null;
        $giro = $_POST['giro'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $departamento = $_POST['departamento'] ?? null;
        $municipio = $_POST['departamento'] ?? null; // Asumimos que departamento y municipio vienen en el mismo campo por ahora
        $telefono_empresa = $_POST['telefono_empresa'] ?? null;
        $correo_empresa = $_POST['correo_empresa'] ?? null;
        $contacto = $_POST['contacto'] ?? null;
        $ncr_contacto = $_POST['ncr_contacto'] ?? null;
        $dui_contacto = $_POST['dui_contacto'] ?? null;
        $correo_contacto = $_POST['correo_contacto'] ?? null;
        $telefono_contacto = $_POST['telefono_contacto'] ?? null;
        $nombre_representante = $_POST['nombre_representante'] ?? null;
        $dui_representante = $_POST['dui_representante'] ?? null;
        $ncr_representante = $_POST['ncr_representante'] ?? null;
        $pasaporte_representante = $_POST['pasaporte_representante'] ?? null;
        $cargo = $_POST['cargo'] ?? null;
        $telefono_representante = $_POST['telefono_representante'] ?? null;
        $correo_representante = $_POST['correo_representante'] ?? null;
        $fechaRegistro = date('Y-m-d');

        $tipoCliente = 'CONTRIBUYENTE JURÍDICO';

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
                NumeroRegistro, TipoCliente, NombreCompleto_NombreLegal_NombreOficial,
                NombreComercial, Fotografia, NIT, RegistroIVA, GiroActividadEconomica,
                DireccionFiscal, Departamento, Municipio, TelefonoEmpresa, CorreoElectronicoEmpresa,
                NombreContacto, NCR, DUIContacto, CorreoElectronicoContacto, TelefonoContacto,
                RepresentanteLegal, DUI, Pasaporte, Cargo, Telefono, CorreoElectronico,
                FechaRegistro
            ) VALUES (
                :registro, :tipoCliente, :nombre_legal,
                :nombre_comercial, :fotografia, :nit, :registro_iva, :giro,
                :direccion, :departamento, :municipio, :telefono_empresa, :correo_empresa,
                :contacto, :ncr_contacto, :dui_contacto, :correo_contacto, :telefono_contacto,
                :nombre_representante, :dui_representante, :pasaporte_representante, :cargo, :telefono_representante, :correo_representante,
                :fechaRegistro
            )");

            $stmt->bindParam(':registro', $registro);
            $stmt->bindParam(':tipoCliente', $tipoCliente);
            $stmt->bindParam(':nombre_legal', $nombre_legal);
            $stmt->bindParam(':nombre_comercial', $nombre_comercial);
            $stmt->bindParam(':fotografia', $fotografia);
            $stmt->bindParam(':nit', $nit);
            $stmt->bindParam(':registro_iva', $registro_iva);
            $stmt->bindParam(':giro', $giro);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':municipio', $municipio);
            $stmt->bindParam(':telefono_empresa', $telefono_empresa);
            $stmt->bindParam(':correo_empresa', $correo_empresa);
            $stmt->bindParam(':contacto', $contacto);
            $stmt->bindParam(':ncr_contacto', $ncr_contacto);
            $stmt->bindParam(':dui_contacto', $dui_contacto);
            $stmt->bindParam(':correo_contacto', $correo_contacto);
            $stmt->bindParam(':telefono_contacto', $telefono_contacto);
            $stmt->bindParam(':nombre_representante', $nombre_representante);
            $stmt->bindParam(':dui_representante', $dui_representante);
            $stmt->bindParam(':pasaporte_representante', $pasaporte_representante);
            $stmt->bindParam(':cargo', $cargo);
            $stmt->bindParam(':telefono_representante', $telefono_representante);
            $stmt->bindParam(':correo_representante', $correo_representante);
            $stmt->bindParam(':fechaRegistro', $fechaRegistro);

            if ($stmt->execute()) {
                header("Location: ../cliente.html");
                exit();
            } else {
                echo "Error al registrar el cliente jurídico.";
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