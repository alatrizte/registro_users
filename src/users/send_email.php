<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

function sendClave($email, $user, $clave){
    //Cargar las variables de entorno con los datos para la conexión a la base de datos.

    include_once ("load_env.php");

    load_env('.env.php');
    $host = getenv("MAIL_HOST");
    $mail_user = getenv("MAIL_USER");
    $mail_pass = getenv("MAIL_PASSWORD");
    $mail_title = getenv("MAIL_TITLE");

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Mostrar todas las respuestas del servidor.
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $mail_user;                             //SMTP username
        $mail->Password   = $mail_pass;                             //SMTP password
        //$mail->SMTPSecure = 'tls';                                //Enable implicit TLS encryption
        $mail->Port       = 25; 
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';                                   

        //Recipients
        $mail->setFrom($mail_user, $mail_title);                    // Correo saliente, titulo correo
        $mail->addAddress($email, $user);                           //Add a recipient
        
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Clave de confirmación';
        $mail->Body    = "Introduzca este código <b>$clave</b> para validar su mail.";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return 'enviado';
    } catch (Exception $e) {
        return "El mensaje no ha podido ser enviado. Error: {$mail->ErrorInfo}";
    }
}
