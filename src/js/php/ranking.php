<?php

class RankingHandler
{
    private $conn;

    public function __construct($servidor, $usuario, $contrasenia, $bbdd)
    {
        $this->conn = new mysqli($servidor, $usuario, $contrasenia, $bbdd);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getRanking()
    {
        $sql = "SELECT nombre, puntuacion, fecha_hora FROM Puntuacion_general ORDER BY puntuacion DESC";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $ranking = array();

            while ($fila = $result->fetch_assoc()) {
                $ranking[] = array(
                    'nombre' => $fila['nombre'],
                    'puntuacion' => $fila['puntuacion'],
                    'fecha_hora' => $fila['fecha_hora']
                );
            }

            header('Content-Type: application/json');
            echo json_encode($ranking);
        } else {
            echo json_encode(array('message' => 'No se encontraron datos en el ranking.'));
        }

        $this->conn->close();
    }
}

require_once 'configdb.php';

$rankingHandler = new RankingHandler($servidor, $usuario, $contrasenia, $bbdd);
$rankingHandler->getRanking();
?>
