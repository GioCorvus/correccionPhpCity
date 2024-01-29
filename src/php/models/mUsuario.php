<?php

require_once __DIR__ . '/../models/mConexion.php';

class MUsuario
{
    private $conexion;

    public function __construct()
    {
        $conexionObj = new MConexion();
        $this->conexion = $conexionObj->getConexion();
    }

    public function login($username, $password)
    {

        $query = "SELECT id, nombre_usuario, password FROM Usuario WHERE nombre_usuario = :username";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
           
            return [
                'id' => $user['id'],
                'nombre_usuario' => $user['nombre_usuario'],
            ];
        }

        return null;
    }

}
?>
