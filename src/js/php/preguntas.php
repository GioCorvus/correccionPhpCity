<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'configdb.php';

$conn = new mysqli($servidor, $usuario, $contrasenia, $bbdd);

// Set the character set to UTF-8
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id_ambito'])) {

    $id_ambito = $_GET['id_ambito'];

    // Practico el usar preparadas
    $sql = "SELECT p.id_pregunta, p.pregunta, r.num_respuesta, r.texto_respuesta
            FROM Pregunta p
            INNER JOIN Respuesta r ON p.id_pregunta = r.id_pregunta
            WHERE p.id_ambito = ?
            ORDER BY p.id_pregunta, r.num_respuesta";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_ambito);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $preguntas = array();
        $pregunta_actual = array();

        while ($fila = $result->fetch_assoc()) {
            if (!isset($pregunta_actual['id_pregunta']) || $pregunta_actual['id_pregunta'] !== $fila['id_pregunta']) {
                if (!empty($pregunta_actual)) {
                    $preguntas[] = $pregunta_actual;
                }
                $pregunta_actual = array(
                    'id_pregunta' => $fila['id_pregunta'],
                    'pregunta' => $fila['pregunta'],
                    'respuestas' => array()
                );
            }

            $pregunta_actual['respuestas'][] = array(
                'num_respuesta' => $fila['num_respuesta'],
                'texto_respuesta' => $fila['texto_respuesta']
            );
        }

        $preguntas[] = $pregunta_actual;
        header('Content-Type: application/json');
        echo json_encode($preguntas, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_IGNORE);
    } else {
        echo json_encode(array('message' => 'No se encontraron preguntas para este ámbito.'));
    }

    $stmt->close();
} else {
    echo json_encode(array('message' => 'ID de ámbito no especificado.'));
}

$conn->close();
?>
