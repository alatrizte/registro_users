### BREVE INTRODUCCIÓN.

Pequeña aplicación para introducir en tus proyectos donde sea necesaria un acceso de usuarios registrados.  
Almacena en una base de datos *Mysql* en el servidor el nombre, el e-mail y la contraseña hasheada. Pedirá al usuario
el e-mail y la contraseña para poder entrar en la aplicación, generando una sesión de usuario. Esta sesión se cerrará 
al cerrar la ventana del navegador.  

Para comprobar la veracidad del mail, enviará a este, antes de formalizar el registro, una clave de confirmación.


### INSTALACIÓN.

Para instalar primero, crear la base de datos Mysql en el servidor.  
Cambiar en el archivo create_db_and_user.sql los nombres de:
- La base de datos (por defecto 'registros')
- El nombre de usuario (por defecto 'vinz')
- El password (por defecto 'clortho_1984')

Ejecutar en una terminal en la carpeta del proyecto:
~~~
sudo mysql < create_db_and_user.sql
~~~

Crear un archivo en la ruta **./src/users/.env.php** para crear las
variables de entorno:  

~~~
<?php 

return [
    "DB_NAME" => "registros",               // igual que la del archivo 'create_db_and_user.sql'
    "DB_USER" => "vinz",                    // 
    "DB_PASSWORD" => "clortho_1984",        //
    "MAIL_HOST" => 'smtp.correo.com',       // dirección smtp del correo
    "MAIL_USER" => 'nombre@correo.com',     // dirección de correo saliente
    "MAIL_PASSWORD" => 'contraseña',        // contraseña del correo
    "MAIL_TITLE" => "Asunto del correo"     // Asunto del correo a enviar las claves
];

?>
~~~

Instalar **Composer** en el servidor.  

Instalar la dependencia **phpmailer 6.8**:  

Ejecuta en una terminal en la carpeta del proyecto:  
~~~
composer require phpmailer/phpmailer
~~~
