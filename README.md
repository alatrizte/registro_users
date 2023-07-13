Para instalar primero crear la base de datos.  
Cambiar en el archivo create_db_and_user.sql los nombres de:
- La base de datos (por defecto 'registros')
- El nombre de usuario (por defecto 'vinz')
- El password (por defecto 'clortho_1984')

Ejecutar en una terminal:
~~~
sudo mysql < create_db_and_user.sql
~~~

Cambiar en el archivo src > clases > .env.php  
Los nombres de usuario y de password usados en la creación de la base de datos.

En el archivo src > send_email.php  
Configurar los datos para el correo saliente

~~~
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.delDominio.com';                  //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'correo@dominio.com';                   //SMTP username
$mail->Password   = 'passCorreo';                           //SMTP password
~~~

También introducir los datos que le aparecerán en el correo del nuevo usuario.  

~~~
$mail->setFrom('correo@dominio.com', 'Registro de Usuarios'); // Correo saliente, Título del correo.
~~~