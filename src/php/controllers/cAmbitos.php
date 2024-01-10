<?php
    require_once __DIR__ . '/../models/mAmbitos.php';
    class  cAmbitos{
        public $nombrePagina;
        public $view;
        public $mensaje;
        public $objAmbitos;
        public function __construct(){
            $this->view = 'vListarAmbitos';
            $this->nombrePagina = 'Listar Ambitos';
            $this->objAmbitos = new mAmbitos();
        }
        public function listarAmbitos(){
            $this->view = 'vListarAmbitos';
            $this->nombrePagina = 'Listar Ambitos';
            $datos = $this->objAmbitos->mListarAmbitos();
            return $datos;
        }

        public function modifAmbitos() {
            if (isset($_POST['id_ambito'], $_POST['nombre'])) {
                $id_ambito = $_POST['id_ambito'];
                $nombre = $_POST['nombre'];
                
                
                if (empty($nombre)) {
                    $this->mensaje = "El campo de nombre no puede estar vacío";
                    $this->mostrarError();
                } elseif (strlen($nombre) > 50) { 
                    $this->mensaje = "El nombre no puede exceder los 50 caracteres";
                    $this->mostrarError();
                } else {
                    $resultado = $this->objAmbitos->mModifAmbitos($id_ambito, $nombre);
                    header("Location: index.php?c=cAmbitos&m=listarAmbitos");
                    exit();
                }
            }
        }
        
        public function mostrarError() {
            $this->view = 'vError'; 
            $datos = array('mensajeError' => $this->mensaje); 
            return $datos;
        }
        
        
        
        
        
        
        
        
        public function obtenerDatos(){
            $this->view = 'vModifAmbito';
    
            if (isset($_GET['idAmbito'])) {
                $id_ambito = $_GET['idAmbito'];
                $datos = $this->objAmbitos->mObtenerAmbito($id_ambito);
                return $datos;
            } 
        }
    }