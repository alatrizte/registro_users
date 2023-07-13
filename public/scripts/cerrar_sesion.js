// Función para cerrar la sesión de usuario.
export const cerrarSesion = () => {
    console.log("cargar modulo");
    fetch('./src/users/cerrar_sesion.php')
    .then (respuesta => respuesta.text())
    .then (data => {
        if (data == "sesion_cerrada") {
            sessionStorage.clear();
            window.location.href = './public/acceso.html';
        }
    })
}