<?php

class MConexion
{
    private $conexion;

    public function __construct()
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

    public function getConexion()
    {
        if ($this->conexion instanceof PDO) {
            return $this->conexion;
        } else {
            
            die("Error: No se pudo obtener la conexión a la base de datos.");
        }
    }
}

?>
