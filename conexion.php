<?php
$hostname = 'localhost';
$database = 'nexus_project_db';
$username = 'root';
$password = '';

$conexion = new mysqli($hostname, $username, $password, $database);

if($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}
?>