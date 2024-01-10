<div class="formularios">
    <form action="index.php?c=cTematicas&m=altaTematicas2" enctype="multipart/form-data" method="post">
        <label for="nombre_tematica">Nombre de la temática:</label>
        <input type="text" id="nombre_tematica" name="nombre_tematica">
        <?php if(isset($_GET["mensaje"]))$mensajeError = $_GET["mensaje"]; if (!empty($mensajeError)) {echo '<div class="error-message">¡' . $mensajeError . '!</div>';}?>
        <table>
            <tr>
                <th>Ámbito</th>
                <th>Nombre del Personaje</th>
                <th>Descripción (Opcional)</th>
                <th>Imagen</th>
            </tr>
            <?php for ($i = 0; $i <5; $i++){ ?>
                <tr>
                    <td>
                        <input type="hidden" id="ambito_<?php echo $i; ?>" name="ambito_<?php echo $i; ?>" value="<?php echo $datos[$i]["id_ambito"]; ?>">
                        <?php echo $datos[$i]["nombre_ambito"];?>
                    </td>

                    <td><input type="text" id="nombre_personaje_<?php echo $i; ?>" name="nombre_personaje_<?php echo $i; ?>"></td>
                    <td><textarea id="descripcion_<?php echo $i; ?>" name="descripcion_<?php echo $i; ?>"></textarea></td>
                    <td><input type="file" id="imagen_<?php echo $i; ?>" name="imagen_<?php echo $i; ?>"></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4"><input type="submit" value="Guardar Temática"></td>
            </tr>
        </table>
    </form>
        <a href="../../src/php/" id="volverAlMenu">Volver al menu</a>
</div>
