<?php

require_once __DIR__ . '/../models/mUsuario.php';

class cAut
{
    public $nombrePagina;
    public $view;
    public $mensaje;
    public $objModelo;

    public function __construct()
    {
        $this->objModelo = new MUsuario();
    }

    public function mostrarLogin(){
        $this->nombrePagina = 'Menú de Administracion';
        $this->view = 'vLogin';
    }

    public function mostrarMenu()
    {
        $this->nombrePagina = 'Menú de Administracion';
        $this->view = 'vMostrarMenuAdmin';
    }

    public function procesarLogin()
    {
        $this->nombrePagina = 'Error de Login';
        $this->view = 'vLogin';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['nombre_usuario'];
            $password = $_POST['password'];

            $user = $this->objModelo->login($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['username'] = $user['nombre_usuario'];

                header('Location: index.php?c=cAut&m=mostrarMenu');
                exit();
            } else {
                $this->mensaje = 'Login failed. Please check your username and password.';
            }
        }
    }

    public function checkSession()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=cAut&m=mostrarLogin'); // redireccion al login
            exit();
        }
    }

    public function cerrarSesion()
    {
        session_start();


        $_SESSION = array();
        // Destroy the session
        session_destroy();
        // Redirect to the login page
        header('Location: index.php?c=cAut&m=mostrarLogin');
        exit();
    }

}
