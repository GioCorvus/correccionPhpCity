<div id="contenedorTabla">
    <table>
        <thead>
            <tr>
                <th>Id. Ámbito</th>
                <th>Nombre del Ámbito</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $fila) { ?>
                <tr>
                    <td><?= $fila['id_ambito'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><a href="index.php?c=cAmbitos&m=obtenerDatos&idAmbito=<?= $fila['id_ambito']; ?>"><img src="../img/edit.png" alt="Editar"></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>