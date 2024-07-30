<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");
include "../conexion.php";

if (!$conexion) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data);

    if ($data) {
        $email = $data->email;
        $password = $data->password;

        $sql = "SELECT id_user, email, password FROM user WHERE email = ? AND password = ?";

        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $email, $password);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result) {
                $objeto = new stdClass();

                if ($fila = $result->fetch_assoc()) {
                    $objeto->id_user = $fila["id_user"];
                    $objeto->email = $fila["email"];
                    $objeto->password = $fila["password"];
                    echo json_encode($objeto);
                } else {
                    $response = ["status" => "No encontrado"];
                    echo json_encode($response);
                }
            } else {
                $response = ["status" => "Error"];
                echo json_encode($response);
            }

            $result->close();
        } else {
            die("Error al preparar la consulta: " . $conexion->error);
        }
    } else {
        die("Datos inválidos");
    }
    mysqli_close($conexion);
}
?>