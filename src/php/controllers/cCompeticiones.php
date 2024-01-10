<?php
/**
 * Controlador para las Competiciones.
 *
 * Maneja las operaciones relacionadas con las competiciones, como listar, crear y borrar.
 *
 * @package CityKids\Controllers
 */
    require_once __DIR__ . '/../models/mCompeticiones.php';

    class cCompeticiones {
        /** @var string El nombre de la página actual. */
        public $nombrePagina;

        /** @var string La vista actual que se va a mostrar. */
        public $view;

        /** @var string|null El mensaje de estado o error después de realizar una operación. */
        public $mensaje;

        /** @var mCompeticiones Objeto de modelo de competiciones. */
        public $objCompeticiones;

        /**
         * Constructor. Inicializa valores predeterminados y crea una instancia del modelo de competiciones.
         */

        public function __construct() {
            $this->view = 'vListarCompeticiones';
            $this->nombrePagina ='';
            $this->objCompeticiones = new mCompeticiones();
        }

        /**
         * Cambia la vista y nombre de la página para mostrar el menú de administrador.
         */

        public function mostrarAdmin(){
            $this->nombrePagina = 'Menu Administrador';
            $this->view = 'vMostrarMenuAdmin';
        }

        /**
         * Lista todas las competiciones.
         *
         * @return array Los datos de las competiciones obtenidos desde el modelo.
         */

        public function listarCompeticiones(){
            $this->view = 'vListarCompeticiones';
            $this->nombrePagina = 'Listar Competiciones';
            $datos =  $this->objCompeticiones->mListarCompeticiones();
            return $datos;
        }

        /**
         * Crea una nueva competición.
         *
         * @return void
         */

        public function crearCompeticiones(){
            $this->view = 'vCrearCompeti';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST["clave"]) && isset($_POST["titulo"]) && isset($_POST["descripcion"]) && isset($_POST["fechaFin"])){

                    $clave = $_POST["clave"];
                    $titulo = $_POST["titulo"];
                    $descripcion = $_POST["descripcion"];
                    $fechaFin = $_POST["fechaFin"];
                    $resultado = $this->objCompeticiones->mCrearCompeticion($clave, $titulo, $descripcion, $fechaFin);
                    switch ($resultado) {
                        case '1292':
                            $this->mensaje = "Valor de fecha y hora incorrecto";
                            break;
                        case '1406':
                            $this->mensaje = "Algun dato excede la longitud máxima permitida";
                            break;
                        case '1062':
                            $this->mensaje = "La clave ya existe, intentalo con otra";
                            break;
                        case '1048':
                            $this->mensaje = "La clave o el titulo no puede estar vacía";
                            break;
                        default:
                            if (is_numeric($resultado)) {
                                $this->mensaje = "Error al crear competición. Código de error: $resultado";
                            } else {
                                $this->mensaje = $resultado;
                            }
                            break;
                    } 
                }
            }
        }
        /**
         * Borra una competición según la clave proporcionada.
         *
         * @return void
         */
        public function borrarCompeticiones(){
            $clave = $_GET['clave'];
            $this->objCompeticiones->mBorrarCompeticion($clave);
        }

        public function modifCompeticiones(){
            $this->view = 'vModifCompeti';
        
            $clave = $_GET['clave'];
            // Obtener los datos de la competición a modificar
            $datos = $this->objCompeticiones->mObtenerCompeticion($clave);
        
            // Pasar los datos a la vista
            return $datos;
        }
        
        public function modifCompeticiones2(){
            if (isset($_POST['clave']) && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['fechaFin'])) {
                $clave = $_POST['clave'];
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $fechaFin = $_POST['fechaFin'];
        
                $datos = $this->objCompeticiones->mModifCompeticion($clave, $titulo, $descripcion, $fechaFin);
            
                // Puedes realizar alguna acción después de la modificación, como redireccionar a la lista de competiciones
                 header("Location: index.php?c=cCompeticiones&m=listarCompeticiones");
                 exit();
        }
    }
    }
?>
