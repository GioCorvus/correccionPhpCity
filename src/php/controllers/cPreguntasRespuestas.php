<?php
    require_once __DIR__ . '/../models/mPreguntasRespuestas.php';

    class cPreguntasRespuestas {
        /** @var string El nombre de la página actual. */
        public $nombrePagina;

        /** @var string La vista actual que se va a mostrar. */
        public $view;

        /** @var string|null El mensaje de estado o error después de realizar una operación. */
        public $mensaje;

        /** @var mCompeticiones Objeto de modelo de competiciones. */
        public $objModelo;

        /**
         * Constructor. Inicializa valores predeterminados y crea una instancia del modelo de preguntas y respuestas.
         */

        public function __construct() {
            $this->view = 'vListarCompeticiones';
            $this->nombrePagina ='';
            $this->objModelo = new MPreguntasRespuestas();
        }

        /*METODO DEL CONTROLADOR DE REDIRECCION AL MENU DE Q&A */


        public function mostrarMenuPreguntasRespuestas(){
            $this->nombrePagina = 'Menu Preguntas y Respuestas';
            $this->view = 'vMenuPreguntasRespuestas';
        }

        /*METODO DEL CONTROLADOR DE REDIRECCION AL FORMULARIO DE ALTA */

        public function mostrarFormPregunta(){
            $this->nombrePagina = 'Alta Pregunta';
            $this->view = 'vAltaPregunta';
        }

        /*METODO DEL CONTROLADOR QUE SE ENCARGA DE DEVOLVER LOS DATOS DEL MODELO PARA EL LISTADO */
        
        public function listarPreguntas(){
            $this->view = 'vListarPreguntas';
            $this->nombrePagina = 'Listar Preguntas';
            $datos =  $this->objModelo->mListarPreguntas();
            return $datos;
        }

        /*METODO DEL CONTROLADOR QUE SE ENCARGA DEL ENVÍO DE LA ID PARA EL BORRADO */
        
        public function borrarPregunta(){
            $this->view = 'vListarPreguntas';
            $this->nombrePagina = 'Listar Preguntas';
            $id_pregunta = $_GET['id_pregunta'];
            $this->objModelo->mBorrarPregunta($id_pregunta);

            // redirecciono de nuevo 
            header("Location: index.php?c=cPreguntasRespuestas&m=listarPreguntas");
            exit();
        }

        /*METODO DEL CONTROLADOR QUE SE ENCARGA DEL ENVÍO DE DATOS PARA EL ALTA */

        public function procesarFormulario(){

            $this->view='vAltaPregunta';
            $this->nombrePagina = 'Alta Preguntas';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                $texto_pregunta = $_POST['texto_pregunta'];
                $id_ambito = $_POST['ambito'];
                $texto_respuesta_correcta = $_POST['texto_respuesta_correcta'];
        
                // obtengo respuestas incorrectas dinámicamente
                $respuestas_incorrectas = [];
                $i = 1;
                while (isset($_POST['texto_respuesta_incorrecta' . $i])) {
                    $respuestas_incorrectas[] = $_POST['texto_respuesta_incorrecta' . $i];
                    $i++;
                }
        
                // construyo el array de respuestas iniciando con la correcta y luego las incorrectas
                $respuestas = ['1' => $texto_respuesta_correcta];
                
                foreach ($respuestas_incorrectas as $indice => $respuesta) {
                    $respuestas[$indice + 2] = $respuesta;
                }
        
                try {
                    // creo la pregunta y respuestas
                    $id_pregunta = $this->objModelo->crearPreguntaYRespuestas($texto_pregunta, $id_ambito, $respuestas);
                    
                    // redirecciono al formulario
                    header("Location: index.php?c=cPreguntasRespuestas&m=listarPreguntas");
                    exit();
                } catch (Exception $mensaje) {
                    $codigoError = $mensaje->getCode();
                    switch ($codigoError) {
                        case 1062:
                            $this->mensaje= "Error al procesar el formulario: Ya existe una pregunta similar.";
                            break;
                        case 1048:
                            $this->mensaje= "Error al procesar el formulario: No puede haber campos vacíos.";
                            break;
                        case 1406:
                            $this->mensaje= "Error al procesar el formulario: Los campos exceden la longitud máxima.";
                            break;
                        default:
                        header("Location: index.php?c=cPreguntasRespuestas&m=listarPreguntas");
                        exit();
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
        
        
        /* MODIFICACION*/

        /* METODO DEL CONTROLADOR QUE SE ENCARGA DE MOSTRAR EL FORMULARIO DE MODIFICACION*/

        public function mostrarModificarPregunta() {
            $id_pregunta = $_GET['id_pregunta'];

            $this->nombrePagina = 'Modificar Pregunta';
            $this->view = 'vModificarPregunta';
        
            $datos = $this->objModelo->obtenerPreguntaYRespuestas($id_pregunta);

            return $datos;
        }

        /* METODO DEL CONTROLADOR QUE SE ENCARGA DE RECOGER LOS DATOS DEL MODIFICADO Y LA GESTIÓN DE ERRORES */
        
        public function procesarFormularioModificar() {

            $this->view='vErrorInput';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                $id_pregunta_a_modificar = $_POST['id_pregunta'];
                $texto_pregunta = $_POST['texto_pregunta'];
                $id_ambito = $_POST['ambito'];
                $texto_respuesta_correcta = $_POST['texto_respuesta_correcta'];
                
                // Obtengo respuestas incorrectas dinámicamente
                $respuestas_incorrectas = [];
                $i = 1;
                while (isset($_POST['texto_respuesta_incorrecta' . $i])) {
                    $respuestas_incorrectas[] = $_POST['texto_respuesta_incorrecta' . $i];
                    $i++;
                }
        
                // Construyo el array de respuestas iniciando con la correcta y luego las incorrectas
                $respuestas = ['1' => $texto_respuesta_correcta];
        
                foreach ($respuestas_incorrectas as $indice => $respuesta) {
                    $respuestas[$indice + 2] = $respuesta;
                }
        
                try {
                    // Actualizo la pregunta y respuestas
                    $id_pregunta_modificada = $this->objModelo->actualizarPreguntaYRespuestas(
                        $id_pregunta_a_modificar,
                        $texto_pregunta,
                        $id_ambito,
                        $respuestas
                    );

                    header("Location: index.php?c=cPreguntasRespuestas&m=listarPreguntas");
                    exit();
        
                } catch (Exception $mensaje) {
                    $codigoError = $mensaje->getCode();
                    switch ($codigoError) {
                        case 1062:
                            $this->mensaje= "Error al procesar el formulario: Ya existe una pregunta similar.";
                            break;
                        case 1048:
                            $this->mensaje= "Error al procesar el formulario: No puede haber campos vacíos.";
                            break;
                        case 1406:
                            $this->mensaje= "Error al procesar el formulario: Los campos exceden la longitud máxima.";
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
        


    }
?>
