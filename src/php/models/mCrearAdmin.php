<?php

require_once __DIR__ . '/../models/mConexion.php';

class MSuperadmin
{
    private $conexion;

    public function __construct()
    {
        $conexionObj = new MConexion();
        $this->conexion = $conexionObj->getConexion();
    }

    public function crearSuperadmin($nombre_usuario, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $tipo_usuario = 1;

        $sql = "INSERT INTO Usuario (nombre_usuario, password, tipo_usuario) VALUES (:nombre_usuario, :hashed_password, :tipo_usuario)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function superadminExists()
    {
        $sql = "SELECT COUNT(*) as count FROM Usuario WHERE tipo_usuario = 1";
        $stmt = $this->conexion->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }


}

?>
