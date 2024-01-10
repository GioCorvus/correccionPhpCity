<div class="formularios">
    <form action="index.php?c=cTematicas&m=modificarTematicas2" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id_tematica" value="<?php echo $datos[0]["id_tematica"]; ?>">

        <label for="nombre_tematica">Título de la Temática:</label>
        <textarea id="nombre_tematica" name="nombre_tematica"><?php echo $datos[0]['nombre_tematica']; ?></textarea><br>

        <table>
            <tr>
                <th>Ámbito</th>
                <th>Nombre del Personaje</th>
                <th>Descripción (Opcional)</th>
                <th>Imagen</th>
            </tr>
            <?php for ($i = 0; $i < 5; $i++) { ?>
                <tr>
                    <td>
                        <input type="hidden" name="id_ambito_<?php echo $i; ?>" value="<?php echo intval($datos['personajes'][$i]['id_ambito']); ?>">
                        <?php echo $datos['personajes'][$i]['nombre_ambito']; ?>
                    </td>
                    <td>
                        <input type="hidden" name="id_personaje_<?php echo $i; ?>" value="<?php echo intval($datos['personajes'][$i]['id_personaje']); ?>">
                        <input type="text" name="nombre_personaje_<?php echo $i; ?>" value="<?php echo $datos['personajes'][$i]['nombre_personaje']; ?>">
                    </td>
                    <td>
                        <textarea name="descripcion_<?php echo $i; ?>"><?php echo $datos['personajes'][$i]['descripcion']; ?></textarea>
                    </td>
                    <td class="imagenes">
                        <input type="file"  name="imagen_<?php echo $i; ?>"><img class="tamanio" src="../img/<?php echo $datos['personajes'][$i]['imagen']; ?>">
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4"><input type="submit" value="Guardar Temática"></td>
            </tr>
        </table>

        <?php
            if (!empty($mensajeError)) {
                echo '<div class="error-message">¡' . $mensajeError . '!</div>';
            }
        ?>

    </form>
</div>
