<?php 
/*
* Si los datos del formulario son correctos se envía un mail
* al nuevo usuario para que valide mediante una clave que la 
* dirección de correo electrónico es correcta. Sólo en ese 
* supuesto se realiza el alta en la base de datos.
*/

session_start();

include_once('send_email.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $userName = $_POST["name"];
    $userMail = $_POST["user"];
   
    $bytes = openssl_random_pseudo_bytes(4);
    $clave = bin2hex($bytes);
    if (sendClave($userMail, $userName, $clave) == "enviado"){
        $_SESSION["userMail"] = $userMail;
        $_SESSION["clave"] = $clave;
        echo "Correo enviado!!";
    };

}

?>