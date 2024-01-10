<?php
    class mTematicas{
        private $conexion;
        
        function __construct(){
            require_once __DIR__ . '/../config/configdb.php';
            $this->conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BBDD);
            if ($this->conexion->connect_error) {
                die("Error de conexión: " . $this->conexion->connect_error);
            }
        
            if (!$this->conexion->set_charset("utf8")) {
                printf("Error al establecer la conexión a UTF-8: %s\n", $this->conexion->error);
                exit();
            }
        }
        function mListarPersonajes($id_tematica){
            $sql = "SELECT personaje.id_personaje as id_personaje, personaje.nombre as nombre_personaje, personaje.descripcion as descripcion, personaje.imagen as imagen, ambito.nombre as nombre_ambito
            FROM Personaje AS personaje
            INNER JOIN Tematica_Ambito_Personaje AS tem ON personaje.id_personaje = tem.id_personaje
            INNER JOIN Ambito AS ambito ON ambito.id_ambito = tem.id_ambito
            WHERE tem.id_tematica = '$id_tematica'";
            
            
            $resultadoPersonajes = $this->conexion->query($sql);
            $datos=[];

            while($fila = $resultadoPersonajes->fetch_assoc()) {
                $datos[] = $fila;
            }
            return $datos;
            
        }
        function mListarTematicas(){
            $sql = "SELECT * FROM Tematica";
            $resultado = $this->conexion->query($sql);
            $datos = [];
            while($fila = $resultado->fetch_assoc())
                $datos[] = $fila;
            return $datos;
        }
        function mObtenerAmbitos(){
            $sql_ambitos = "SELECT id_ambito as id_ambito, nombre as nombre_ambito FROM Ambito";
            $resultado_ambitos = $this->conexion->query($sql_ambitos);

            if ($resultado_ambitos->num_rows > 0) {
                $datos = [];
                while ($fila = $resultado_ambitos->fetch_assoc()) {
                    $datos[] = $fila;
            }
            return $datos;
            }
        }
        function mObtenerTematicayPersonajes($id_tematica){
            $sql_tematica = "SELECT id_tematica, nombre as nombre_tematica FROM Tematica";
            $resultado_tematica = $this->conexion->query($sql_tematica);
        
            $sql_personajes = "SELECT personaje.id_personaje, personaje.nombre as nombre_personaje, descripcion, imagen, ambito.id_ambito, ambito.nombre as nombre_ambito FROM Personaje AS personaje
            INNER JOIN Tematica_Ambito_Personaje as tem_amb_pers ON personaje.id_personaje = tem_amb_pers.id_personaje 
            INNER JOIN Ambito as ambito ON ambito.id_ambito=tem_amb_pers.id_ambito
            WHERE tem_amb_pers.id_tematica = $id_tematica";
            $resultado_personajes = $this->conexion->query($sql_personajes);
        
            if ($resultado_tematica->num_rows > 0) {
                $datos_tematica = [];
                
                // Agregar información de la temática al array
                while($fila_tematica = $resultado_tematica->fetch_assoc()){
                    $datos_tematica[] = $fila_tematica;
                }
                
        
                // Agregar información de los personajes al array
                $datos_personajes = [];
                while ($fila_personajes = $resultado_personajes->fetch_assoc()) {
                    $datos_personajes[] = $fila_personajes;
                }
                $datos_tematica['personajes'] = $datos_personajes;
        
                return $datos_tematica;
            } else {
                throw new Exception("Error al obtener datos de la temática y personajes: " . $this->conexion->error);
            }
        }
        
        function mModificarTematicayPersonajes($id_tematica, $nombre_tematica, $personajes){
            $sql_modificar_tematica = "UPDATE Tematica SET nombre = '$nombre_tematica' WHERE id_tematica = '$id_tematica'";
            $this->conexion->query($sql_modificar_tematica);
            foreach ($personajes as $i => $personaje) {
                $imagen = null;
                if (isset($_FILES["imagen_$i"]) && file_exists($_FILES["imagen_$i"]["tmp_name"])) {
                    $imagen = $_FILES["imagen_$i"];
                    $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
                    $nombreimagen = uniqid() . "." . $ext;
                    $carpeta_final = __DIR__ . "/../../img";
                    $ruta_inicial = $imagen["tmp_name"];
                    $ruta_final = $carpeta_final . DIRECTORY_SEPARATOR . $nombreimagen;
                    move_uploaded_file($ruta_inicial, $ruta_final);
                }
            
                $id_personaje = $personaje['id_personaje'];
                $nombre_personaje = $personaje['nombre_personaje'];
                $descripcion = $personaje['descripcion'];
            
                if ($imagen !== null) {
                    $sql_modificar_personaje = "UPDATE Personaje SET nombre = '$nombre_personaje', descripcion='$descripcion', imagen = '$nombreimagen' WHERE id_personaje = '$id_personaje'";
                } else {
                    $sql_modificar_personaje = "UPDATE Personaje SET nombre = '$nombre_personaje', descripcion='$descripcion' WHERE id_personaje = '$id_personaje'";
                }
            
                $this->conexion->query($sql_modificar_personaje);
            }
        }
        
        function mAltaTematicas($nombretematica, $personajes) {
            $nombretematica = empty($nombretematica) ? "NULL" : "'" . $this->conexion->real_escape_string($nombretematica) . "'";
        
            try {
                $this->conexion->begin_transaction();
                $sql_insertar_tematica = "INSERT INTO Tematica(nombre) VALUES ($nombretematica)";
                $this->conexion->query($sql_insertar_tematica);
                $id_tematica = $this->conexion->insert_id;
                foreach ($personajes as $i => $personaje) {
                    $id_ambito = (int)$personaje["ambito_$i"];
                    if(empty($personaje["nombre_personaje_$i"])){
                        $nombrepersonaje = $personaje["nombre_personaje_$i"]; 
                        $nombrepersonaje= "NULL";
                        $errorNombrePersonaje = ("Error: El nombre de algun personaje está vacio.");
                        throw new Exception($errorNombrePersonaje , 0001);
                    }else{
                        $nombrepersonaje = $this->conexion->real_escape_string($personaje["nombre_personaje_$i"]);
                    }
                    $descripcion = $this->conexion->real_escape_string($personaje["descripcion_$i"]);
        
                        if (isset($personaje["imagen_$i"])) {
                            $imagen = $personaje["imagen_$i"];
                            $ext = pathinfo($imagen["name"], PATHINFO_EXTENSION);
                            
                            // Lista de extensiones permitidas
                            $extensiones_permitidas = array("png", "jpg", "jpeg");
                        
                            // Valida si la extensión está en la lista permitida
                            if (in_array(strtolower($ext), $extensiones_permitidas)) {
                                $nombreimagen = uniqid() . "." . $ext;
                                $carpeta_final = __DIR__ . "/../../img";
                                $ruta_inicial = $imagen["tmp_name"];
                                $ruta_final = $carpeta_final . DIRECTORY_SEPARATOR . $nombreimagen;
                                move_uploaded_file($ruta_inicial, $ruta_final);
                            } else {
                                //devuelvo un mensaje personalizado que muestra el texto del error que la extension no está permitida
                                $errorExtension = ("Error: La extensión del archivo no está permitida.");
                                throw new Exception($errorExtension , 0002);
                            }
                        }
                
                        
        
                    $sql_insertar_personaje = "INSERT INTO Personaje (nombre, descripcion, imagen) VALUES ('$nombrepersonaje', '$descripcion', '$nombreimagen')";
                    $this->conexion->query($sql_insertar_personaje);
                    $id_personaje = $this->conexion->insert_id;

                    $sql_insertar_todo = "INSERT INTO Tematica_Ambito_Personaje(id_tematica, id_ambito, id_personaje) VALUES ('$id_tematica', '$id_ambito', '$id_personaje')";
                    $this->conexion->query($sql_insertar_todo);
                    }           
        
                $this->conexion->commit();
        
            } catch (Exception $e) {
                $this->conexion->rollback();
                throw $e;
            }
        }
        
        
        

        function mBorrarTematicas($id_tematica){
            $sql = "SELECT personaje.id_personaje, personaje.imagen as imagen
            FROM Personaje AS personaje
            INNER JOIN Tematica_Ambito_Personaje AS tem ON personaje.id_personaje = tem.id_personaje
            WHERE tem.id_tematica = '$id_tematica'";
            
            $resultado = $this->conexion->query($sql);
            $datos = [];
        
            while ($fila = $resultado->fetch_assoc()) {
                $datos[] = $fila;
            }
            
            $sql = "DELETE FROM Tematica_Ambito_Personaje WHERE id_tematica = '$id_tematica'";

            $resultado = $this->conexion->query($sql);

            $sql = "DELETE FROM Tematica WHERE id_tematica = '$id_tematica'";

            $resultado = $this->conexion->query($sql);

            foreach ($datos as $fila) {
                $imagen = $fila['imagen'];
                $ruta_inicial = __DIR__ . "/../../img/" . $imagen;
                $ruta_final = __DIR__ . "/../../img_borradas/" . $imagen;
        
                if (file_exists($ruta_inicial)) {
                    // Mover el archivo a la carpeta de imágenes borradas
                    rename($ruta_inicial, $ruta_final);
                }
                $id_personaje = $fila ['id_personaje'];
                $id_personaje = (int)$id_personaje;
                $sql = "DELETE FROM Personaje WHERE id_personaje = $id_personaje";
                $resultado = $this->conexion->query($sql);
                
            }           
            //Nos redireccionamos de nuevo al listar tematicas, por si queremos borra una nueva tematica
            header("Location: index.php?c=cTematicas&m=listarTematicas");
            exit();
        }
    }
?>