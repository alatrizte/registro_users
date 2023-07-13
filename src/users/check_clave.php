<?php 

// Comprueba la clave introducida en el formulario de registro 
// con la clave que se envía por Mail para comprobar la cuenta de mail.
// En caso de que coincidan la clave de sesión (enviada por mail)
// y la clave que se introduce por formulario que procede a dar de alta a un nuevo usuario.

include_once ("../clases/Database.php");

//Cargar las variables de entorno con los datos para la conexión a la base de datos.

include_once ("load_env.php");

load_env('.env.php');
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $clave = $_POST["clave"];

    session_start();

    if ($clave === $_SESSION["clave"]){

        $conn = new Database($dbname, $username, $pass);

        $userName = $_SESSION["userName"];
        $userMail = $_SESSION["userMail"];
        $userPass = password_hash($_SESSION["userPass"], PASSWORD_DEFAULT);

        $conn->query('INSERT INTO users (user_name, user_mail, user_pass) VALUES (?, ?, ?)', [$userName, $userMail, $userPass]);
        session_destroy();
        echo "correcta";
    } else {
        echo "Clave incorrecta";
    }
}
?>