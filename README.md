Para instalar primero crear la base de datos.  
Cambiar en el archivo create_db_and_user.sql los nombres de:
- La base de datos (por defecto 'registros')
- El nombre de usuario (por defecto 'vinz')
- El password (por defecto 'clortho_1984')

Ejecutar en una terminal:
~~~
sudo mysql < create_db_and_user.sql
~~~

Crear un archivo en la ruta src/users/.env.php para crear las
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