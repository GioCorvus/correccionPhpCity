<div class="contenedor">
    <form action="index.php?c=cPreguntasRespuestas&m=procesarFormulario" method="post" onsubmit="return validarFormularioEnviado()">
        <label for="texto_pregunta">Texto de la Pregunta:</label>
        <textarea id="texto_pregunta" name="texto_pregunta" class="campo-texto"></textarea><br>

        <label for="ambito">Ámbito:</label>
        <select id="ambito" name="ambito">
            <option value="1">1: Participación Democrática.</option>
            <option value="2">2: Justicia Social</option>
            <option value="3">3: Desarrollo Humano y Sostenible</option>
            <option value="4">4: Interculturalidad e Inclusion</option>
            <option value="5">5: Equidad de genero y Coeducacion</option>
        </select><br>

        <label for="texto_respuesta_correcta">Texto de la Respuesta Correcta:</label>
        <input type="text" id="texto_respuesta_correcta" name="texto_respuesta_correcta" class="campo-texto"><br>

        <label for="texto_respuesta_incorrecta1">Texto de la Respuesta Incorrecta 1:</label>
        <input type="text" id="texto_respuesta_incorrecta1" name="texto_respuesta_incorrecta1" class="campo-texto"><br>

        <label for="texto_respuesta_incorrecta2">Texto de la Respuesta Incorrecta 2:</label>
        <input type="text" id="texto_respuesta_incorrecta2" name="texto_respuesta_incorrecta2" class="campo-texto"><br>

        <div id="respuestas_incorrectas_container">
            <!-- Aquí se agregarán dinámicamente las respuestas incorrectas -->
        </div>

        <div class="input-group">
            <input type="button" value="+" onclick="agregarRespuestaIncorrecta()">
            <input type="button" value="-" onclick="eliminarRespuestaIncorrecta()">
        </div>

        <input type="submit" value="Guardar Pregunta">
        
        <?php
        if (!empty($mensajeError)) {
            echo '<div class="error-message">¡' . $mensajeError . '!</div>';
        }
        ?>

    </form>

        <a href="../../src/php/index.php?c=cPreguntasRespuestas&m=mostrarMenuPreguntasRespuestas" id="volverAlMenu">Volver al menu Q&A</a>

    <script src="views/js/botones.js"></script>
    <script src="views/js/validarformulariopreguntas.js"></script>


</div>
