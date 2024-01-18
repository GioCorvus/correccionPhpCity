<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
    <link rel="stylesheet" href="../css/estiloAdmin.css">
</head>
    <body>
        <div>
            <nav>
                <ul>
                    <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=mostrarFormPregunta">Añadir Pregunta</a></li>
                    <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=listarPreguntas">Listar Preguntas</a></li>
                </ul>
            </nav>
            <header class="mb-5">
                <div>
                    <h1><?php echo $controlador->nombrePagina; ?></h1>
                </div>
            </header>