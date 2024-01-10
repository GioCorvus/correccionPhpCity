
    <div id="contenedorTabla">
        <table>
            <thead>
                 <tr>
                    <th>Titulo</th>
                    <th>Clave</th>
                    <th>Descripción</th>
                    <th>Fecha/Hora Fin</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $fila) { ?>
                    <tr>
                        <td><?= $fila['titulo'] ?></td>
                        <td><?= $fila['clave'] ?></td>
                        <td><?= $fila['descripcion'] !== NULL ? $fila['descripcion'] : 'No se ha introducido ninguna descripción' ?></td>
                        <td><?= $fila['fecha_hora_fin'] ?></td>
                        <td><a href="index.php?c=cCompeticiones&m=borrarCompeticiones&clave=<?php echo $fila['clave']; ?>"><img src="../img/delete.png"></a></td>
                        <td><a href="index.php?c=cCompeticiones&m=modifCompeticiones&clave=<?= $fila['clave']; ?>"><img src="../img/edit.png"></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
