<?php

require_once __DIR__ . '/../models/mCrearAdmin.php';

class CSuperadmin
{
    public $nombrePagina;

    public $view;

    public $mensaje;

    public $objModelo;

    public function __construct()
    {
        $this->view = 'vCrearSuperAdmin';
        $this->nombrePagina = '';
        $this->objModelo = new MSuperadmin();
    }

    public function verificarSuperadminExistente()
    {
        $superadminExists = $this->objModelo->superadminExists();

        if ($superadminExists) {

            $this->mensaje = "A superadmin already exists.";
            $this->view = 'vError'; 
        }
    }

    public function mostrarFormSuperadmin()
    {
        $this->nombrePagina = 'Create Superadmin';

        $this->verificarSuperadminExistente();

        if ($this->view !== 'vError') {
            $this->view = 'vCreateAdmin';
        }
    }

    public function procesarFormularioCrearSuperadmin()
    {

        
        $this->nombrePagina = 'Super admin creado';

        $this->view = 'vError'; 

        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $this->objModelo->crearSuperadmin($nombre_usuario, $hashedPassword);

        // header("Location: index.php?c=cSuperadmin&m=exitoCrearSuperadmin");
        exit();
    }

}

?>
