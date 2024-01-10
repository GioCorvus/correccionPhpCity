
    <div id="contenedorNegro">
        <h1 class="main-title-white">MODIFICA COMPETICIÓN</h1>
        <form action="index.php?c=cCompeticiones&m=modifCompeticiones2" method="POST">
            <label for="clave">Introducir clave:</label>
            <input type="text" id="clave" name="clave" value="<?php echo $datos['clave']; ?>" >

            <label for="titulo">Introducir título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $datos['titulo']; ?>" >

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?php echo $datos['descripcion']; ?></textarea>

            <label for="fechaFin">Selecciona hora y día de fin:</label>
            <input type="datetime-local" id="fechaFin" name="fechaFin" value="<?php echo $datos['fecha_hora_fin']; ?>" >

            <input type="submit" name="enviar" value="Modificar">
        </form>
        <a href="index.php" class="volverAlJuego">VOLVER AL MENÚ</a>  
    </div>
