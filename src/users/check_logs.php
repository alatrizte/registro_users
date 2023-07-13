<?php 
// Controlador para logueo de usuario
// si los datos de user y password coinciden con los de la base de datos logeo OK

include_once("../clases/Database.php");

//Cargar las variables de entorno con los datos para la conexión a la base de datos.

include_once ("load_env.php");

load_env('.env.php');
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $userMail = $_POST["user"];
    $userPass = $_POST["password"];

    $conn = new Database($dbname, $username, $pass);
    $consulta = $conn->queryData("SELECT * FROM users WHERE user_mail = ?", [$userMail]);
    if ($consulta){
        $passHash = $consulta[0]->user_pass;
   
        if (password_verify($userPass, $passHash)){
            session_start();
            $_SESSION["userName"] = $consulta[0]->user_name;
            $_SESSION["userID"] = $consulta[0]->id;
            
            echo json_encode(password_verify($userPass, $passHash));
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
}
?>