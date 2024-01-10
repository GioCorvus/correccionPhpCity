<div class="contenedor">
    <form action="index.php?c=cPreguntasRespuestas&m=procesarFormularioModificar&id=id_pregunta" method="post">

        <input type="hidden" name="id_pregunta" value="<?= $datos['id_pregunta'] ?>">

        <label for="texto_pregunta">Texto de la Pregunta:</label>
        <textarea id="texto_pregunta" name="texto_pregunta"><?=$datos['pregunta'] ?></textarea><br>
        
        <label for="ambito">Ámbito:</label>
        <select id="ambito" name="ambito">
            <option value="1" <?= ($datos['id_ambito'] == 1) ? 'selected' : '' ?>>1: Participación Democrática.</option>
            <option value="2" <?= ($datos['id_ambito'] == 2) ? 'selected' : '' ?>>2: Justicia Social</option>
            <option value="3" <?= ($datos['id_ambito'] == 3) ? 'selected' : '' ?>>3: Desarrollo Humano y Sostenible</option>
            <option value="4" <?= ($datos['id_ambito'] == 4) ? 'selected' : '' ?>>4: Interculturalidad e Inclusión</option>
            <option value="5" <?= ($datos['id_ambito'] == 5) ? 'selected' : '' ?>>5: Equidad de género y Coeducación</option>
        </select><br>

        <label for="texto_respuesta_correcta">Texto de la Respuesta Correcta:</label>
        <input type="text" id="texto_respuesta_correcta" name="texto_respuesta_correcta" value="<?= isset($datos['respuestas'][0]['texto_respuesta']) ? $datos['respuestas'][0]['texto_respuesta'] : '' ?>"><br>

        <label for="texto_respuesta_incorrecta2">Texto de la Respuesta Incorrecta 1:</label>
        <input type="text" id="texto_respuesta_incorrecta1" name="texto_respuesta_incorrecta1" value="<?= isset($datos['respuestas'][1]['texto_respuesta']) ? $datos['respuestas'][1]['texto_respuesta'] : '' ?>"><br>

        <label for="texto_respuesta_incorrecta2">Texto de la Respuesta Incorrecta 2:</label>
        <input type="text" id="texto_respuesta_incorrecta2" name="texto_respuesta_incorrecta2" value="<?= isset($datos['respuestas'][2]['texto_respuesta']) ? $datos['respuestas'][2]['texto_respuesta'] : '' ?>"><br>

        <div id="respuestas_incorrectas_container">
            <?php
                for ($i = 3; $i < count($datos['respuestas']); $i++) {
                    echo '<label for="texto_respuesta_incorrecta' . $i . '">Texto de la Respuesta Incorrecta ' . $i . ':</label>';
                    echo '<input type="text" id="texto_respuesta_incorrecta' . $i . '" value="' . $datos['respuestas'][$i]['texto_respuesta'] . '">';
                }
            ?>
        </div>

        <div class="input-group">
            <input  type="button" value="+" onclick="agregarRespuestaIncorrecta()">
            <input type="button" value="-" onclick="eliminarRespuestaIncorrecta()">
        </div>

        <input type="submit" value="Guardar Pregunta">

        <?php
            if (!empty($mensajeError)) {
                echo '<div class="error-message">¡' . $mensajeError . '!</div>';
            }
        ?>

    </form>

    <a href="../../src/php/index.php?c=cPreguntasRespuestas&m=listarPreguntas" id="volverAlMenu">Volver al listado</a>

    <script src="views/js/botones.js"></script>
    
</div>

