-- Crear la base de datos
CREATE DATABASE registros;

-- Crear un usuario con contraseña
CREATE USER 'vinz'@'localhost' IDENTIFIED BY 'clortho_1984';

-- Crear la tabla de users
USE registros;
CREATE TABLE IF NOT EXISTS users (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, user_name VARCHAR(50), user_mail VARCHAR(128), user_pass VARCHAR(128));

-- Otorgar todos los privilegios al usuario en la base de datos
GRANT ALL PRIVILEGES ON registros.* TO 'vinz'@'localhost';

-- Aplicar los cambios de privilegios
FLUSH PRIVILEGES;
