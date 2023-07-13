<?php

// Se cierra la sesión de usuario.

session_start();
session_destroy();
echo "sesion_cerrada";
?>