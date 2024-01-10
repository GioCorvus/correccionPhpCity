    <div id="contenedorTabla">
        <table>
            <thead>
                <tr>
                    <th>Id. Personaje</th>
                    <th>Nombre del personaje</th>
                    <th>Descripcion</th>
                    <th>Imagen</th> 
                    <th>Ambito</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $fila){?>
                    <tr>
                        <td><?php echo $fila['id_personaje'] ?></td>
                        <td><?php echo $fila['nombre_personaje'] ?></td>
                        <td><?php echo $fila['descripcion'] ?></td>
                        <td class="imagenes"><img src="../img/<?php echo $fila['imagen'] ?>" alt="Imagen del personaje" class="tamanio"></td>
                        <td class="ambitos"><?php echo $fila['nombre_ambito'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>