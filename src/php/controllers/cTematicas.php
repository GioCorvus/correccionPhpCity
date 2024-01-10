<?php
    require_once __DIR__ . '/../models/mTematicas.php';
    class  cTematicas{
        public $nombrePagina;
        public $view;
        public $mensaje;
        public $objTematicas;
        public function __construct(){
            $this->view = 'vListarTematicas';
            $this->nombrePagina = 'Listar Tematicas';
            $this->objTematicas = new mTematicas();
        }
        public function listarTematicas(){
            $this->view = 'vListarTematicas';
            $this->nombrePagina = 'Listar Tematicas';
            $datos = $this->objTematicas->mListarTematicas();
            return $datos;
        }
        public function listarPersonajes(){
            $this->view = 'vListarPersonajes';
            $this->nombrePagina = 'Listar Personajes';
            $id_tematica = $_GET["id_tematica"];
            $datos = $this->objTematicas->mListarPersonajes($id_tematica);
            return $datos;
        }
        public function altaTematicas() {
            $this->view = 'vAltaTematicas';
            $this->nombrePagina = 'Alta Tematicas';
            $datos = $this->objTematicas->mObtenerAmbitos();
            return $datos;
        }

        public function altaTematicas2() {
            $this->view = 'vAltaTematicas';
            $this->nombrePagina = 'Alta Tematicas';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombretematica = $_POST["nombre_tematica"];
                $personajes = [];
                
        
                for ($i = 0; $i <= 4; $i++) {
                    $id_ambito = $_POST["ambito_$i"];
                    $nombre_personaje = $_POST["nombre_personaje_$i"];
                    $descripcion = $_POST["descripcion_$i"];
                    $imagen = $_FILES["imagen_$i"];
                    
                    $personaje = [
                        "ambito_$i" => $id_ambito,
                        "nombre_personaje_$i" => $nombre_personaje,
                        "descripcion_$i" => $descripcion,
                        "imagen_$i" => $imagen
                    ];
        
                    $personajes[] = $personaje;
                }
                try{
                // creo la temática y personajes
                    $this->objTematicas->mAltaTematicas($nombretematica, $personajes);
                    header("Location: index.php?c=cTematicas&m=listarTematicas");
                    exit();
                } catch (Exception $mensaje) {
                    //pregunto si el codigo del mensaje es numerico para acceder al switch case, si no lo es, muestro el mensaje de texto
                    if (is_numeric($mensaje->getCode())) {
                        $codigoError = $mensaje->getCode();
                    
                        switch ($codigoError) {
                            case 1048:
                                $this->mensaje= "Error al procesar el formulario: No puede estar la temática vacía.";
                                header("Location: index.php?c=cTematicas&m=altaTematicas&mensaje=$this->mensaje");
                                break;
                            case 1406:
                                $this->mensaje= "Error al procesar el formulario: Los campos exceden la longitud máxima.";
                                header("Location: index.php?c=cTematicas&m=altaTematicas&mensaje=$this->mensaje");
                                break;
                            case 00001:
                                $this->mensaje = $mensaje->getMessage();
                                header("Location: index.php?c=cTematicas&m=altaTematicas&mensaje=$this->mensaje");
                                break;
                            case 00002:
                                $this->mensaje = $mensaje->getMessage();
                                header("Location: index.php?c=cTematicas&m=altaTematicas&mensaje=$this->mensaje");
                                break;
                            default:
                                header("Location: index.php?c=cTematicas&m=listarTematicas");
                                break;
                            
                        }
                    }
                }
                
            }
        }

        public function modificarTematicas(){
            $this->view = 'vModificarTematica';
            $this->nombrePagina = ' Modificar Tematicas';
            $id_tematica = $_GET['id_tematica'];
            $datos = $this->objTematicas->mObtenerTematicayPersonajes($id_tematica);
            return $datos;
        }

        public function modificarTematicas2(){
            //deberia de preguntar que si algun campo de los obligatorios, se deja como vacio, que salga un error, y que no se modifiquen los datps
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener los datos del formulario
                $id_tematica = $_POST['id_tematica'];
                $nombre_tematica = $_POST['nombre_tematica'];
        
                // Crear un array para almacenar los datos de los personajes
                $personajes = [];
        
                // Recorrer los datos de los personajes
                for ($i = 0; $i < 5; $i++) {
                    $id_personaje = isset($_POST["id_personaje_$i"]) ? $_POST["id_personaje_$i"] : null;
                    $nombre_personaje = isset($_POST["nombre_personaje_$i"]) ? $_POST["nombre_personaje_$i"] : null;
                    $descripcion = isset($_POST["descripcion_$i"]) ? $_POST["descripcion_$i"] : null;
                    $imagen = isset($_FILES["imagen_$i"]) ? $_FILES["imagen_$i"] : null;
        
                    // Crear un array con los datos del personaje
                    $personaje = [
                        'id_personaje' => $id_personaje,
                        'nombre_personaje' => $nombre_personaje,
                        'descripcion' => $descripcion,
                        'imagen' => $imagen,
                    ];
                    $personajes[] = $personaje;
                }
        
                $this->objTematicas->mModificarTematicayPersonajes($id_tematica, $nombre_tematica, $personajes);
                header("Location: index.php?c=cTematicas&m=listarTematicas");
                
            }
        }
        
        public function borrarTematicas(){
            $id_tematica = $_GET['id_tematica'];
            $this->objTematicas->mBorrarTematicas($id_tematica);
            header("Location: index.php?c=cTematicas&m=listarTematicas");
            exit();
        }
    }
