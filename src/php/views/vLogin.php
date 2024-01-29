<div class="contenedor">

<form method="post" action="index.php?c=cAut&m=procesarLogin">
    <!-- Your form fields here -->
    <input type="text" name="nombre_usuario" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <?php
    if (!empty($mensajeError)) {
        echo '<div class="error-message">¡' . $mensajeError . '!</div>';
    }
    ?>
</form>



</div>