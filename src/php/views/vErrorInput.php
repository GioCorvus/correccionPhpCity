    <div id="contenedor">
        <div id="contenedorError">
            <h1>Error de introducción de datos.</h1>
            <?php
                if (!empty($mensajeError)) {
                    echo '<div class="error-message">' . $mensajeError . '</div>';
                }
            ?>
            <p><a href="../../src/php/index.php?c=cPreguntasRespuestas&m=listarPreguntas" id="volverAlMenu">Volver al listado</a></p>
        </div>
    </div>
