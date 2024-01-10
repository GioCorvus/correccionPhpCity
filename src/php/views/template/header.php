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
                    <li><a href="../../src/php/index.php?c=cCompeticiones&m=listarCompeticiones">Listar Competiciones</a></li>
                    <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=mostrarFormPregunta">Añadir Pregunta</a></li>
                    <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=listarPreguntas">Listar Preguntas</a></li>
                    <li><a href="../../src/php/index.php?c=cAmbitos&m=listarAmbitos">Gestión de Ámbitos</a></li>
                    <li><a href="../../src/php/index.php?c=cTematicas&m=altaTematicas">Alta Tematicas</a></li>
                    <li><a href="../../src/php/index.php?c=cTematicas&m=listarTematicas">Listar Tematicas</a></li>
                </ul>
            </nav>
            <header class="mb-5">
                <div>
                    <h1><?php echo $controlador->nombrePagina; ?></h1>
                </div>
            </header>