<?php 

/* Se conecta a la base de datos para comprobar si el mail introducido ya está en esta.
En caso afirmativo se devuelve un error para no continuar con el proceso de registro.
En caso negativo se devuelve un mesaje para continuar con el registro.
*/

include_once("../clases/Database.php");

//Cargar las variables de entorno con los datos para la conexión a la base de datos.

include_once ("load_env.php");

load_env('.env.php');
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $userMail = $_POST["userMail"];

    $conn = new Database($dbname, $username, $pass);
    
    $consulta = $conn->query('SELECT * FROM users WHERE user_mail = ?', [$userMail]);
    if (explode(", ", $consulta)[0] === "Error"){
        echo explode(", ", $consulta)[0];
    } else {
        if ($consulta === true){
            echo "existe"; // fallo
        } else {
            echo "unico"; // correcto
        }
    }
}

?>