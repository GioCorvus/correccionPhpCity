<?php

    class CInicio {

        public $nombrePagina;

        public $view;

        public function __construct() {
            $this->view = '';
            $this->nombrePagina ='';
        }

        public function mostrarMenuAdmin(){
            $this->nombrePagina = 'Login';
            $this->view = 'vLogin';
        }

    }
?>