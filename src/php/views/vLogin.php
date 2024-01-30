<?php

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?c=cAut&m=mostrarMenu');
    exit();
}

// Continue with the rest of your HTML/PHP code for the login view
?>

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