<div id="contenedorNegro">
    <h1 class="main-title-white">MODIFICA ÁMBITO</h1>
    <form action="index.php?c=cAmbitos&m=modifAmbitos" method="POST">
        <label for="id_ambito">Id Ámbito:</label>
        <input type="text" id="id_ambito" name="id_ambito" value="<?= $datos['id_ambito']; ?>" readonly>
        <!-- El atributo 'readonly' hace que el campo sea de solo lectura -->
        
        <label for="nombre">Modifica Ámbito:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $datos['nombre']; ?>" >
        
        <input type="submit" name="enviar" value="Modificar">
    </form>
    <a href="index.php?c=cAmbitos&m=listarAmbitos" class="volverAlJuego">VOLVER AL MENÚ</a>  
</div>
