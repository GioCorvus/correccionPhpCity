<?php

class MPreguntasRespuestas
{
    private $conexion;

    function __construct()
    {
        require_once __DIR__ . '/../config/configdb.php';

        try {
            $dsn = "mysql:host=" . SERVIDOR . ";dbname=" . BBDD;
            $this->conexion = new PDO($dsn, USUARIO, CONTRASENIA);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    function mListarPreguntas()
    {
        $sql = "SELECT Pregunta.*, Ambito.nombre as nombre_ambito, Respuesta.texto_respuesta as texto_respuesta_correcta
            FROM Pregunta
            JOIN Ambito ON Pregunta.id_ambito = Ambito.id_ambito
            LEFT JOIN Respuesta ON Pregunta.id_pregunta = Respuesta.id_pregunta AND Pregunta.num_respuesta_correcta = Respuesta.num_respuesta
            ORDER BY Ambito.id_ambito, Pregunta.id_pregunta";

        $stmt = $this->conexion->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    public function mBorrarPregunta($id_pregunta)
    {
        $sql = "DELETE FROM Pregunta WHERE id_pregunta = :id_pregunta";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function crearPreguntaYRespuestas($pregunta, $ambito, $respuestas)
    {
        $pregunta = empty($pregunta) ? null : $pregunta;
        $ambito = empty($ambito) ? null : $ambito;

        $this->conexion->beginTransaction();

        try {
            $sql_insertar_pregunta = "INSERT INTO Pregunta (pregunta, id_ambito) VALUES (:pregunta, :ambito)";
            $stmt = $this->conexion->prepare($sql_insertar_pregunta);
            $stmt->bindParam(':pregunta', $pregunta, PDO::PARAM_STR);
            $stmt->bindParam(':ambito', $ambito, PDO::PARAM_INT);
            $stmt->execute();

            $id_pregunta = $this->conexion->lastInsertId();

            foreach ($respuestas as $num_respuesta => $texto_respuesta) {
                $texto_respuesta = empty($texto_respuesta) ? null : $texto_respuesta;
                $sql_insertar_respuesta = "INSERT INTO Respuesta (id_pregunta, num_respuesta, texto_respuesta) VALUES (:id_pregunta, :num_respuesta, :texto_respuesta)";
                $stmt_respuesta = $this->conexion->prepare($sql_insertar_respuesta);
                $stmt_respuesta->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
                $stmt_respuesta->bindParam(':num_respuesta', $num_respuesta, PDO::PARAM_INT);
                $stmt_respuesta->bindParam(':texto_respuesta', $texto_respuesta, PDO::PARAM_STR);
                $stmt_respuesta->execute();

                if ($num_respuesta == 1) {
                    $sql_actualizar_respuesta_correcta = "UPDATE Pregunta SET num_respuesta_correcta = :num_respuesta WHERE id_pregunta = :id_pregunta";
                    $stmt_actualizar_respuesta_correcta = $this->conexion->prepare($sql_actualizar_respuesta_correcta);
                    $stmt_actualizar_respuesta_correcta->bindParam(':num_respuesta', $num_respuesta, PDO::PARAM_INT);
                    $stmt_actualizar_respuesta_correcta->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
                    $stmt_actualizar_respuesta_correcta->execute();
                }
            }

            $this->conexion->commit();
            return $id_pregunta;
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw $e;
        }
    }

    public function obtenerPreguntaYRespuestas($id_pregunta)
    {
        $sql_pregunta = "SELECT * FROM Pregunta WHERE id_pregunta = :id_pregunta";
        $stmt_pregunta = $this->conexion->prepare($sql_pregunta);
        $stmt_pregunta->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
        $stmt_pregunta->execute();

        $datos_pregunta = $stmt_pregunta->fetch(PDO::FETCH_ASSOC);

        $sql_respuestas = "SELECT * FROM Respuesta WHERE id_pregunta = :id_pregunta";
        $stmt_respuestas = $this->conexion->prepare($sql_respuestas);
        $stmt_respuestas->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
        $stmt_respuestas->execute();

        $datos_respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($datos_respuestas)) {
            $datos_pregunta['respuestas'] = $datos_respuestas;
        }

        return $datos_pregunta;
    }

    public function actualizarPreguntaYRespuestas($id_pregunta_a_actualizar, $pregunta, $ambito, $respuestas)
    {
        try {
            $this->conexion->beginTransaction();

            $sql_eliminar_pregunta_y_respuestas = "DELETE FROM Pregunta WHERE id_pregunta = :id_pregunta";
            $stmt_eliminar_pregunta_y_respuestas = $this->conexion->prepare($sql_eliminar_pregunta_y_respuestas);
            $stmt_eliminar_pregunta_y_respuestas->bindParam(':id_pregunta', $id_pregunta_a_actualizar, PDO::PARAM_INT);
            $stmt_eliminar_pregunta_y_respuestas->execute();

            $pregunta = empty($pregunta) ? null : $pregunta;
            $ambito = empty($ambito) ? null : $ambito;

            $sql_insertar_pregunta = "INSERT INTO Pregunta (id_pregunta, pregunta, id_ambito) VALUES (:id_pregunta, :pregunta, :ambito)";
            $stmt_insertar_pregunta = $this->conexion->prepare($sql_insertar_pregunta);
            $stmt_insertar_pregunta->bindParam(':id_pregunta', $id_pregunta_a_actualizar, PDO::PARAM_INT);
            $stmt_insertar_pregunta->bindParam(':pregunta', $pregunta, PDO::PARAM_STR);
            $stmt_insertar_pregunta->bindParam(':ambito', $ambito, PDO::PARAM_INT);
            $stmt_insertar_pregunta->execute();

            foreach ($respuestas as $num_respuesta => $texto_respuesta) {
                $texto_respuesta = empty($texto_respuesta) ? null : $texto_respuesta;

                $sql_insertar_respuesta = "INSERT INTO Respuesta (id_pregunta, num_respuesta, texto_respuesta) VALUES (:id_pregunta, :num_respuesta, :texto_respuesta)";
                $stmt_insertar_respuesta = $this->conexion->prepare($sql_insertar_respuesta);
                $stmt_insertar_respuesta->bindParam(':id_pregunta', $id_pregunta_a_actualizar, PDO::PARAM_INT);
                $stmt_insertar_respuesta->bindParam(':num_respuesta', $num_respuesta, PDO::PARAM_INT);
                $stmt_insertar_respuesta->bindParam(':texto_respuesta', $texto_respuesta, PDO::PARAM_STR);
                $stmt_insertar_respuesta->execute();

                if ($num_respuesta == 1) {
                    $sql_actualizar_respuesta_correcta = "UPDATE Pregunta SET num_respuesta_correcta = :num_respuesta WHERE id_pregunta = :id_pregunta";
                    $stmt_actualizar_respuesta_correcta = $this->conexion->prepare($sql_actualizar_respuesta_correcta);
                    $stmt_actualizar_respuesta_correcta->bindParam(':num_respuesta', $num_respuesta, PDO::PARAM_INT);
                    $stmt_actualizar_respuesta_correcta->bindParam(':id_pregunta', $id_pregunta_a_actualizar, PDO::PARAM_INT);
                    $stmt_actualizar_respuesta_correcta->execute();
                }
            }

            $this->conexion->commit();
            return $id_pregunta_a_actualizar;
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw $e;
        }
    }
}

?>
