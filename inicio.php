<?php
    session_start();
    $scriptEnabled = isset($_GET['script']) && $_GET['script'] === 'enabled';


    if (!$scriptEnabled) {
        // Redirigir a otra página
        header('Location: index.html');
    } else if (!$_SESSION['userID']){
        header('Location: public/acceso.html');
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuarios</title>
</head>

<body>
    <script defer type="module">
        import { cerrarSesion } from './public/scripts/cerrar_sesion.js';
        // Comprueba que exista una sesion de usuario, si no la hay
        // redirige la página a acceso
        fetch('./src/users/check_session.php')
            .then(respuesta => respuesta.json())
            .then(data => {
                if (Object.values(data)[0] == "no_sesion") {
                    window.location.href = './public/acceso.html'
                } else {
                    sessionStorage.setItem('userID', Object.keys(data)[0])
                    sessionStorage.setItem('userName', Object.values(data)[0])
                    let userName = sessionStorage.getItem('userName');
                    document.getElementById("user").innerHTML = `${userName} <button>Cerrar</button>`;
                    const btn_cerrarSession = document.querySelector("#user button");
                    btn_cerrarSession.addEventListener("click", cerrarSesion)
                }
            })
    </script>
    <div id="user"></div>
    <h1>Bienvenido</h1>
    <p>Aquí irá la página de inicio de tu aplicación.</p> 
    <p>Si has llegado hasta aquí es que el usuario se ha registrado correctamente.</p>
</body>

</html>