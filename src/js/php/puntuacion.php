<?php
require_once 'configdb.php';


$conn = new mysqli($servidor, $usuario, $contrasenia, $bbdd);

$conn->set_charset("utf8mb4");

$nombre = $_POST['nombre'];
$puntuacion = $_POST['puntuacion'];

$sql = "INSERT INTO Puntuacion_general (nombre, puntuacion, fecha_hora) VALUES ('$nombre', $puntuacion, NOW())";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array('message' => 'Registro insertado correctamente'));
} else {
    echo json_encode(array('error' => 'Error al insertar el registro: ' . $conn->error));
}

$conn->close();
?>