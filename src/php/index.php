<?php
// Incluir archivos necesarios
    require_once __DIR__ .'/config/configdb.php';
    require_once __DIR__ .'/config/default.php';


    if(!isset($_GET["c"])) $_GET["c"] = constant("CONTROLADOR_DEFECTO");
    if(!isset($_GET["m"])) $_GET["m"] = constant("METODO_DEFECTO");

    // Ruta del Controlador
    $rutaControlador = __DIR__ .'/controllers/'.$_GET['c'].'.php';
    require_once $rutaControlador;
    $controladorNombre = $_GET['c'];
    $controlador = new $controladorNombre();

    $metodo = $_GET['m'];
    

    // Obtener los datos del método del controlador
    $datos = $controlador->$metodo();


    // Obtener el mensaje de error del controlador si existe
    $mensajeError = isset($controlador->mensaje) ? $controlador->mensaje : '';

    //Para que valga tanto con html como con php:
    $cuerpoPHP = __DIR__ . '/views/' . $controlador->view . '.php';
    $cuerpoHTML = __DIR__ . '/views/' . $controlador->view . '.html';

    // CARGAR VISTAS

    //primero, el header
    require_once __DIR__ .'/views/template/header.php';

    //luego, el body
    //Comprobacion distintos tipos de vista, php o html
    if (file_exists($cuerpoPHP)) {
        require_once $cuerpoPHP;
    } elseif (file_exists($cuerpoHTML)) {
        require_once $cuerpoHTML;
    } else {
        require_once __DIR__ . '/views/vError404.php';
    }

    //por ultimo, el footer
    require_once __DIR__ .'/views/template/footer.html';
?>
