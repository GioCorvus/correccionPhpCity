<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Crear Competición</title>
</head>
<body>
    </div>
   
    <div id="contenedorNegro">
        <h1 class="main-title-white">CREAR COMPETICIÓN</h1>
        <form action="index.php?c=cCompeticiones&m=crearCompeticiones" method="POST">
            <label for="clave">Introducir clave:</label>
            <input type="text" id="clave" name="clave">

            <label for="titulo">Introducir título:</label>
            <input type="text" id="titulo" name="titulo">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>

            <label for="fechaFin">Selecciona hora y día de fin:</label>
            <input type="datetime-local" id="fechaFin" name="fechaFin">

            <input type="submit" name="enviar" value="Enviar">
        </form>
        <?php
        if (!empty($mensajeError)) {
            echo '<div class="error-message">¡' . $mensajeError . '!</div>';
        }
        ?>
        <a href="index.php" class="volverAlJuego">VOLVER AL MENÚ</a>  
    </div>
    
</body>
</html>
