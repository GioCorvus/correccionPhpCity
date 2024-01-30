<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/estiloAdmin.css">
</head>
<body>
<?php
// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    // Display the menu only if there's an active session
?>
    <div>
        <nav>
            <ul>
                <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=mostrarFormPregunta">Añadir Pregunta</a></li>
                <li><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=listarPreguntas">Listar Preguntas</a></li>
                <li><a href="../../src/php/index.php?c=cAut&m=cerrarSesion">Cerrar Sesión</a></li>

            </ul>
        </nav>
        <header class="mb-5">
            <div>
                <h1><?php echo $controlador->nombrePagina; ?></h1>
            </div>
        </header>
    </div>
<?php
} else {
    // Display a message or nothing when there is no active session
    // You can customize this part based on your requirements
    echo '<p>Please log in to access the menu.</p>';
}
?>
</body>
</html>
