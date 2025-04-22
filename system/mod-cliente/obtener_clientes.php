<?php
header('Content-Type: application/json'); // Indicamos que la respuesta será en formato JSON
include '../conexion/conexion.php';

try {
    $stmt = $conn->prepare("SELECT
        ID,
        NombreCompleto_NombreLegal_NombreOficial AS NombreCompleto,
        TipoCliente,
        NombreComercial,
        Fotografia
    FROM tb_cliente");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatear los datos para que coincidan con las columnas de la tabla HTML
    $data = array();
    foreach ($clientes as $cliente) {
        $nombreCompleto = explode(' ', $cliente['NombreCompleto'], 2);
        $nombre = isset($nombreCompleto[0]) ? $nombreCompleto[0] : '';
        $apellido = isset($nombreCompleto[1]) ? $nombreCompleto[1] : '';

        $data[] = array(
            'Foto' => $cliente['Fotografia'] ? base64_encode($cliente['Fotografia']) : null, // Codificar la foto a Base64
            'ID' => $cliente['ID'],
            'Nombre' => $nombre,
            'Apellido' => $apellido,
            'TipoCliente' => $cliente['TipoCliente'],
            'Empresa' => $cliente['NombreComercial'] ? $cliente['NombreComercial'] : '-', // Usar NombreComercial como "Empresa"
            'Acciones' => '<button class="btn btn-view" onclick="verCliente(\'' . $cliente['ID'] . '\')">Ver</button>
                           <button class="btn btn-edit" onclick="modificarCliente(\'' . $cliente['ID'] . '\')">Modificar</button>
                           <button class="btn btn-delete" onclick="eliminarCliente(\'' . $cliente['ID'] . '\')">Eliminar</button>'
        );
    }

    echo json_encode(array('data' => $data));

} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

$conn = null;
?>