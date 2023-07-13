<?php 

/* Comprobar si hay una sesión de usuario abierta para mostrar sus proyectos.
*/

session_start();

if (isset($_SESSION['userID'])){
    $userSesion = [$_SESSION['userID'] => $_SESSION['userName']];
} else {
    $userSesion = ["error" => "no_sesion"];
}

// Respuesta al cliente
echo json_encode($userSesion);
?>