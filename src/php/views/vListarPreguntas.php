<div id="contenedorTabla">
    <table>
        <thead>
             <tr>
                <th>ID</th>
                <th>Pregunta</th>
                <th>Ámbito</th>
                <th>Respuesta Correcta</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $fila) { ?>
                <tr>
                    <td><?= $fila['id_pregunta'] ?></td>
                    <td><?= $fila['pregunta'] ?></td>
                    <td><?= $fila['nombre_ambito'] ?></td>
                    <td><?= $fila['texto_respuesta_correcta'] ?></td>
                    <td><a href="index.php?c=cPreguntasRespuestas&m=borrarPregunta&id_pregunta=<?php echo $fila['id_pregunta']; ?>"><img src="../img/delete.png"></a></td>
                    <td><a href="index.php?c=cPreguntasRespuestas&m=mostrarModificarPregunta&id_pregunta=<?= $fila['id_pregunta']; ?>"><img src="../img/edit.png"></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="../../src/php/index.php?c=cPreguntasRespuestas&m=mostrarMenuPreguntasRespuestas" id="volverAlMenu">Volver al menu Q&A</a>

</div>

<script src="views/js/confirmacion.js"></script>
