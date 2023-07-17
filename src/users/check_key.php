<?php 
/*
Checkeo de la clave para cambio de password
Esta función compara la enviada por correo con la que hay en la sesión
si es la misma el resultado es ok.
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $clave = $_POST["clave"];

    session_start();
    if ($clave === $_SESSION["clave"]){
        echo "ok";
    } else {
        echo "incorrecto";
    }
}