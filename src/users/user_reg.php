<?php 
/*
* Si los datos del formulario son correctos se envía un mail
* al nuevo usuario para que valide mediante una clave que la 
* dirección de correo electrónico es correcta. Sólo en ese 
* supuesto se realiza el alta en la base de datos.
*/

session_start();

include_once('send_email.php');

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $userName = $_POST["name"];
    $userMail = $_POST["user"];
    $userPass = $_POST["password"];
    $confirm =$_POST["pass_conf"];

    $patron = "/^(?=.*[A-Z])(?=.*\d).{8,}$/";

    $resultado = "OK"; 

    // comprueba el password:
    // 8 caracteres, uno en mayúsculas y un dígito.
    if (!preg_match($patron, $userPass)){
        $resultado = "error validación contraseña.";
    }

    // comprueba que no haya variables vacias.
    if ($userName == "" || $userMail == "" || $userPass == ""){
        $resultado = "campos vacios";
    }

    // comprueba que el password y confirmación sean iguales.
    if ($userPass !== $confirm){
        $resultado = "error coincidencia de contraseñas.";
    }

    //echo $resultado;

    if ($resultado == "OK"){
        $bytes = openssl_random_pseudo_bytes(4);
        $clave = bin2hex($bytes);
        if (sendClave($userMail, $userName, $clave) == "enviado"){
            $_SESSION["clave"] = $clave;
            $_SESSION["userName"] = $userName;
            $_SESSION["userMail"] = $userMail;
            $_SESSION["userPass"] = password_hash($userPass, PASSWORD_DEFAULT);
            
        };
    }
}
?>