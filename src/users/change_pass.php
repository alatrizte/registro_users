<?php 
/**
 * Tras la comprobación de la clave se cambia el password en la base de datos.
 */

 include_once ("../clases/Database.php");

//Cargar las variables de entorno con los datos para la conexión a la base de datos.

include_once ("load_env.php");

load_env('.env.php');
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");

 if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    $conn = new Database($dbname, $username, $pass);

    $userMail = $_SESSION["userMail"];
    $userPass = $_POST["password"];
    $confirm =$_POST["pass_conf"];
    if ($userPass === $confirm) {
        $userPass_hash = password_hash($userPass, PASSWORD_DEFAULT);

        $conn->query("UPDATE users SET user_pass = ? WHERE user_mail = ? ",[$userPass_hash, $userMail]);
        echo "ok";
        session_destroy();
    } else {
        echo "datos erroneos.";
    }
    
 }
?>