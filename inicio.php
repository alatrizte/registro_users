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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;800&display=swap');

        * {
            font-family: 'Montserrat', sans-serif;
            box-sizing: border-box;
            margin: 0px;
        }

        #user {
            text-align: center;
            margin-top: 20px;
            text-transform: capitalize;
        }

        #user button {
            margin-left: 15px;
        }

        .container {
            width: 700px;
            margin: auto;
            margin-top: 25px;
            padding: 25px;
            padding-bottom: 125px;
            border: 1px solid #2a6e7d;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 50px;
            color: #2a6e7d;
        }

        h1, p {
            text-align: center;
        }

        p {
            font-size: 14px;
        }

        @media (max-width: 700px) {
            .container {
                width: 100%;
            }
        }
    </style>
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
                    // Almacena en sessionStorage las variables de usuario.
                    sessionStorage.setItem('userID', Object.keys(data)[0])
                    sessionStorage.setItem('userName', Object.values(data)[0])
                    let userName = sessionStorage.getItem('userName');
                    document.getElementById("user").innerHTML = `${userName} <button>Cerrar</button>`;
                    const btn_cerrarSession = document.querySelector("#user button");
                    btn_cerrarSession.addEventListener("click", cerrarSesion)
                }
            })
    </script>


    <!-- A partir de aquí es un ejemplo de como sería la página de inicio -->
    <div id="user"></div>
    <div class="container">
        <p><i>Si has llegado hasta aquí es que el usuario se ha registrado correctamente.</i></p>
        <h1>Bienvenido</h1>
        <p>Aquí irá la página de inicio de tu aplicación.</p> 
        <p>...</p>
    </div>
</body>

</html>