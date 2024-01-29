<?php

$contrasena_original = '123';

$hash = password_hash($contrasena_original, PASSWORD_DEFAULT);

echo 'Contraseña original: ' . $contrasena_original . "<br>";
echo 'Hash de la contraseña: ' . $hash . "<br>";

$contrasena_ingresada = '123';

echo 'Contraseña ingresada: ' . $contrasena_ingresada . "<br>";

$resultado_verify = password_verify($contrasena_ingresada, $hash);

if ($resultado_verify) {
    echo '¡Contraseña correcta! Acceso permitido.<br>';
} else {
    echo 'Contraseña incorrecta. Acceso denegado.<br>';
}

echo "Resultado de password_verify(): " . ($resultado_verify ? 'true' : 'false');

?>
