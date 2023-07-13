<?php
//Función para cargar las variables de entorno

function load_env($env_file) {
    if (file_exists($env_file)) {
        $env_vars = include $env_file;
        foreach ($env_vars as $key => $value) {
            putenv("$key=$value");
        }
    } else {
        throw new Exception("Environment file not found: $env_file");
    }
}

?>