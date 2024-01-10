<?php
require_once 'configdb.php';


$conn = new mysqli($servidor, $usuario, $contrasenia, $bbdd);

$conn->set_charset("utf8mb4");

$clave = $_POST['clave'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fechaFin = $_POST['fechaFin'];

$sql = "INSERT INTO Competicion (clave,descripcion, titulo, fecha_hora_fin) VALUES ('$clave','$descripcion', '$titulo',  '$fechaFin')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array('message' => 'Registro insertado correctamente'));
} else {
    echo json_encode(array('error' => 'Error al insertar el registro: ' . $conn->error));
}

$conn->close();
?>