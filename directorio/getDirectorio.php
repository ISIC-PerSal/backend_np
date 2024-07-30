<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");
include "../conexion.php";

phpinfo();

if (!$conexion) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    $pais = $_GET['pais'] ?? '';
    $ods = $_GET['ods'] ?? '';

    if ($pais == '' && !empty($ods)) {
        $sql = "SELECT * FROM directorio_ods_pais WHERE id_ods = '" . $ods . "'";
    } else if ($ods == '' && !empty($pais)) {
        $sql = "SELECT * FROM directorio_ods_pais WHERE pais = '" . $pais . "'";
    } else if ($pais == ''&& $ods == '') {
        $sql = "SELECT * FROM directorio_ods_pais";
    } else {
        $sql = "SELECT * FROM directorio_ods_pais WHERE pais = '" . $pais . "' AND id_ods = '" . $ods . "'";
    }
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        $dataArray = array();

        while ($fila = $result->fetch_assoc()) {
            $objeto = new stdClass();
            $objeto->nombre = $fila["nombre"];
            $objeto->link = $fila["link"];
            $objeto->imagen = $fila["imagen"];
            $objeto->descripcion = $fila["descripcion"];
            $objeto->email = $fila["email"];
            $objeto->telefono = $fila["telefono"];
            $objeto->direccion = $fila["direccion"];
            $objeto->pais = $fila["pais"];
            $objeto->id_ods = $fila["id_ods"];
            $objeto->ods = $fila["ods"];
            $dataArray[] = $objeto;
        }
        echo json_encode($dataArray);
    } else {
        $response = ["status" => "Error"];
        echo json_encode($response);
    }

    $result->close();
    mysqli_close($conexion);
}
?>