<?php

/**
 * Modelo para las Competiciones.
 *
 * Contiene métodos para manejar operaciones relacionadas con las competiciones en la base de datos.
 *
 * @package CityKids\Models
 */

class mCompeticiones {
    /** @var mysqli La conexión a la base de datos. */
    private $conexion;

    /**
     * Constructor. Establece la conexión a la base de datos y verifica la conexión UTF-8.
     */

    function __construct() {
        require_once __DIR__ . '/../config/configdb.php';
        $this->conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BBDD);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    
        // Establecer la codificación a UTF-8
        if (!$this->conexion->set_charset("utf8")) {
            printf("Error al establecer la conexión a UTF-8: %s\n", $this->conexion->error);
            exit();
        }
    }

    /**
     * Obtiene una lista de todas las competiciones desde la base de datos.
     *
     * @return array Un array con los datos de las competiciones.
     */   

    function mListarCompeticiones() {
        $sql = "SELECT * FROM Competicion";
        $resultado = $this->conexion->query($sql);
        $datos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        return $datos;
    }

    /**
     * Crea una nueva competición con los datos proporcionados.
     *
     * @param string $clave La clave de la competición.
     * @param string $titulo El título de la competición.
     * @param string $descripcion La descripción de la competición.
     * @param string $fechaFin La fecha de finalización de la competición.
     *
     * @return string|int El mensaje de estado o el código de error.
     */

    function mCrearCompeticion($clave, $titulo, $descripcion, $fechaFin) {
        try {
            $clave = ($clave === '') ? "NULL" : "'" . $clave . "'";
            //$variable = ($condicion) ? $valor_si_cierto : $valor_si_falso; 
            //Por ejemplo en este caso, la variable cavle es igual a espacio en blanco, colocaría un null y si no lo es colocaria los datos que se han mandado con la variable
            $descripcion= ($descripcion === '') ? "NULL" : "'" . $descripcion . "'";
            $titulo= ($titulo === '') ? "NULL" : "'" . $titulo . "'";

            $sql = "INSERT INTO Competicion (clave, descripcion, titulo, fecha_hora_fin) 
            VALUES ($clave, $descripcion, $titulo, '$fechaFin')";

            if ($this->conexion->query($sql) === TRUE) {
                $mensaje = "La competición se ha creado correctamente.";
            } else {
                // Si hay un error en la consulta, lanzar una excepción con el mensaje de error
                throw new Exception($this->conexion->error, $this->conexion->errno);
            }
        
            // Retornar el mensaje que indica el resultado de la inserción
            return $mensaje;
        } catch (Exception $error) {
            //Coge la excepción
            $numeroError = $error->getCode(); // Obtiene el código de error de la variable $error
            //Retornamos el numero del error, en este caso al controlador
            return $numeroError;
        }
    }
    
    /**
     * Borra una competición según la clave proporcionada.
     *
     * @param string $clave La clave de la competición a borrar.
     *
     * @return void
     */

    function mBorrarCompeticion($clave){
        $sql = "DELETE FROM Competicion WHERE clave = '$clave'";
        $this->conexion->query($sql);
        //Nos redireccionamos de nuevo al listar competiciones, por si queremos borra una nueva competicion
        header("Location: index.php?c=cCompeticiones&m=listarCompeticiones");
        exit();
    }

    function mModifCompeticion($clave, $titulo, $descripcion, $fechaFin){
        $sql = "UPDATE Competicion  SET titulo = '$titulo', descripcion = '$descripcion', fecha_hora_fin = '$fechaFin' WHERE clave = '$clave'";
        $this->conexion->query($sql);
        
    }

    function mObtenerCompeticion($clave){
        $sql = "SELECT * FROM Competicion WHERE clave = '$clave'";
        $resultado = $this->conexion->query($sql);
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        } else {
            return null; // Opcional: Puedes manejar el caso si no se encuentra ninguna competición con esa clave
        }
    }
}
?>