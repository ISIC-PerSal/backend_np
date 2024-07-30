<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");
include "../conexion.php";

if(!$conexion){
    die("Error de conexión: " . $conexion->connect_error);
}else{
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data);

    if($data){
        $email = $data->email;
        $password = $data->password;

        $sql = "INSERT INTO user (email, password) VALUES (?, ?)";

        $result = $conexion->prepare($sql);

        if($result){
            $result->bind_param("ss", $email, $password);

            $result->execute();

            if($result){
                $response = ["status"=>"Creado"];
                echo json_encode($response);
            }else{
                $response = ["status"=>"Error"];
                echo json_encode($response);
            }

            $result->close();
        }else{
            die("Error al preparar la consulta: " . $conexion->error);
        }
    }else{
        die("Datos inválidos");
    }
    mysqli_close($conexion);
}
?>