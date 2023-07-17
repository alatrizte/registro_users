const loginForm = document.getElementById("loginForm");
const regForm = document.getElementById("regForm");

const check = document.getElementById("check");

const entrar = document.getElementById("entrar");
const registro = document.getElementById("registro");
const alert_reg = document.getElementById("alert_reg");
alert_reg.style.display = "none";

const alert_log = document.getElementById("alert_log");
alert_log.style.display = "none";

const mail = document.getElementById("mail");

const forget = document.getElementById("forget");

//regForm.style.display = "none";

// Función que muestra el formulario de identificarse
const logueo = (e) => {
    e.preventDefault();
    regForm.style.top = "-10%";
    loginForm.style.transform = "translateY(-50%)";
    loginForm.style.opacity = "100%";
    regForm.style.opacity = "0%";
}

//Función que muestra el formulario de registro
const newReg = () => {
    loginForm.style.transform = "translateY(-550px)";
    loginForm.style.opacity = "0%";
    regForm.style.top = "-64%";
    regForm.style.opacity = "100%";
}

/* LOGUEO */

// Función para acceder a la aplicación. Se envian los datos 
// de identificación al servidor y este inicia sesión.
const entrando = async (e) => {
    e.preventDefault();
    const loginFormData = new FormData(loginForm);
    vacio = false;

    loginFormData.forEach(item => {
        if (item == "") {
            vacio = true;
        }
    })

    if (vacio == true) {
        for (element of loginForm.elements) {
            element.parentElement.classList.remove("inputAlert"); //aquí hay que poner la clase en estado normal
            if (element.value == "") {
                element.parentElement.classList.add("inputAlert"); //aquí hay que poner la clase en estado aviso
                alert_log.innerHTML = "Has de cubrir todos los campos";
                alert_log.style.display = "block";
            }
        };
    } else {
        const consulta = await fetch('../src/users/check_logs.php', {
            method: 'POST',
            body: loginFormData
        })
        const respuesta = await consulta.json();

        if (respuesta) {
            loginForm.reset();
            document.location.href = "../index.html";
        } else {
            alert_log.innerHTML = "No existe un usuario con los datos introducidos.";
            alert_log.style.display = "block";
        }
    }
}

/* REGISTRO */

// comprueba que los passwords sean válidos
const check_pass_valid = (data) => {
    let pass = data.get('password');

    // el password ha de tener minimo: 
    // 8 caracters, un dígito y una letra mayúscula
    const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

    // si la contraseña cumple formato:
    if (regex.test(pass)) {
        // Si las contraseñas son iguales:
        if (pass == data.get('pass_conf')) {
            return true
        } else {
            alert_reg.innerHTML = "Las contraseñas no son iguales.";
            alert_reg.style.display = "block";
            return false
        }
    } else {
        alert_reg.innerHTML = "Las contraseñas no tienen un formato válido";
        alert_reg.style.display = "block";
        return false
    }

}

// Comprueba que no haya en la base de datos otro
// usuario con el mismo mail.
const check_is_unique = async (data) => {
    let email = data.get('user');

    const dataToSend = new FormData();
    dataToSend.append('userMail', email);
    const consulta = await fetch('../src/users/check_mail_unique.php', {
        method: 'POST',
        body: dataToSend
    })
    const respuesta = await consulta.text();

    if (respuesta == "unico") {
        return true
    } else if (respuesta === "existe") {
        mail.innerHTML = "El E-Mail ya está registrado";
        return false
    }

}

// Función que envia los datos de registro al servidor
const enviarRegistro = async (data) => {
    const consulta = await fetch('../src/users/user_reg.php', {
        method: 'POST',
        body: data
    });
    const respuesta = await consulta.text();
    //console.log(respuesta);
}

// Función para comprobar la clave que se envia por correo
// Sirve para saber si el email es verdadero.
const check_clave = () => {
    login.style.display = "none";
    regForm.style.transform = "translateY(-70%)";
    regForm.style.opacity = "0%";
    check.style.opacity = "100%";
    check.style.top = "-90%";

    const btn_envio = document.getElementById("envio");
    const btn_cancel = document.getElementById("cancel");

    btn_cancel.addEventListener("click", () => {
        location.reload(true);
    })

    // Comprobar en el servidor si la clave es correcta
    btn_envio.addEventListener("click", (e) => {
        e.preventDefault();
        let claveData = new FormData(check);
        fetch('../src/users/check_clave.php', {
            method: 'POST',
            body: claveData,
        })
            .then(respuesta => respuesta.text())
            .then(data => {
                if (data === "correcta") {
                    check.reset();
                    alert("El usuario ha sido registrado correctamente!!");
                    location.reload(true);
                } else {
                    alert("La clave introducida es incorrecta.");
                    console.log("Clave incorrecta");
                }
            })
    })

}

// Función para enviar los datos de registro al servidor
// y que se almacenen el la base de datos.
const registrando = (e) => {
    e.preventDefault();

    const regFormData = new FormData(regForm);
    //console.log(regFormData.get('pass_conf'));
    vacio = true;
    regFormData.forEach(item => {
        if (item == "") {
            vacio = false;
        }
    })
    if (vacio == false) {
        for (element of regForm.elements) {
            element.parentElement.classList.remove("inputAlert"); //aquí hay que poner la clase en estado normal
            if (element.value == "") {
                element.parentElement.classList.add("inputAlert"); //aquí hay que poner la clase en estado aviso
                alert_reg.innerHTML = "Todos los campos son obligatorios.";
                alert_reg.style.display = "block";
            }
        };
    } else {
        if (check_pass_valid(regFormData)) {
            alert_reg.style.display = "none";
            let email = regFormData.get('user');
            mail.innerHTML = "";
            const regex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
            if (regex.test(email)) {
                if (check_is_unique(regFormData)) {
                    enviarRegistro(regFormData);
                    regForm.reset();
                    check_clave();
                }
            } else {
                mail.style.display = "block";
                mail.innerHTML = "El E-mail no tiene un formato válido.";
                return false;
            }
        }
    }
}


const change_pass = (e) => {

    e.preventDefault();

    const regFormData = new FormData(regForm);

    vacio = true;
    regFormData.forEach(item => {
        if (item == "") {
            vacio = false;
        }
    })
    if (vacio == false) {
        for (element of regForm.elements) {
            element.parentElement.classList.remove("inputAlert"); //aquí hay que poner la clase en estado normal
            if (element.value == "") {
                element.parentElement.classList.add("inputAlert"); //aquí hay que poner la clase en estado aviso
                alert_reg.innerHTML = "Todos los campos son obligatorios.";
                alert_reg.style.display = "block";
            }
        };
    } else {
        if (check_pass_valid(regFormData)) {
            alert_reg.style.display = "none";
            mail.innerHTML = "";
            console.log(regFormData);
            fetch ('../src/users/change_pass.php',{
                method: 'POST',
                body: regFormData
            })
                .then (consulta => consulta.text() )
                .then (respuesta => {
                    if(respuesta == "ok"){
                        alert ("La contraseña ha sido cambiada.");
                        regForm.reset();
                        location.reload(true);
                    }
                }) 
        }
    }
}


// Función para cambiar el password del usuario registrado.
// utiliza el mismo formulario de registro pero enviará a la base de datos
// el nuevo password que como paso de confirmación se envía una clave 
// al correo del usuario. Sólo en el momento de introducir esa clave se 
// cambiará el password del usuario.
const new_pass = (itName, itMail) => {
    // Cambia el título
    document.querySelector("#regForm h3").textContent = "Nueva Contraseña";
    // Elimina el boton de registro.
    document.querySelector("#registro").remove();
    // Introduce en los inputs los valores del nombre y del mail
    const name = document.getElementById("name");
    const reg_user = document.getElementById("reg_user");
    name.value = itName;
    reg_user.value = itMail;
    // desactiva los campos para no poder cambiar los valores.
    name.setAttribute("disabled", true);
    reg_user.setAttribute("disabled", true);
    // Elimina el enlace hacia el login.
    document.getElementById("login").remove();
    // Crea los botones para aceptar o cancelar los cambios.
    const btn_cambiar = document.createElement("input");
    btn_cambiar.setAttribute("type", "submit");
    btn_cambiar.value = "Cambiar";
    const btn_back = document.createElement("input");
    btn_back.setAttribute("type", "button");
    btn_back.value = "Cancelar";
    document.getElementById("btns_reg").append(btn_cambiar);
    document.getElementById("btns_reg").append(btn_back);

    // al pulsar el botón 'Cambiar'.
    btn_cambiar.addEventListener("click", change_pass);

    // Al pulsar el botón 'Cancelar'
    btn_back.addEventListener("click", () => {
        location.reload(true);
    })
}

const check_exist = async (log_user) => {
    const dataToSend = new FormData();
    dataToSend.append('userMail', log_user);
    const consulta = await fetch('../src/users/check_mail_exist.php', {
        method: 'POST',
        body: dataToSend
    })

    const respuesta = await consulta.text();

    return respuesta;
}

const send_key = async(log_user, name) => {
    let data = new FormData();
    data.append("name", name);
    data.append("user", log_user);
    const consulta = await fetch('../src/users/send_key.php', {
        method: 'POST',
        body: data
    });
    const respuesta = await consulta.text();
    console.log(respuesta);
}

forget.addEventListener("click", async () => {
    const log_user = document.getElementById("log_user").value;
    if (log_user === "") {
        alert("Has de introducir tu e-mail");
    } else {
        let consulta = await check_exist(log_user);
        // Petición al servidor para comprobar si el email existe en la base de datos.
        if (consulta != 0) {
            send_key(log_user, consulta);

            loginForm.style.transform = "translateY(-550px)";
            loginForm.style.opacity = "0%";
            check.style.opacity = "100%";
            check.style.top = "-90%";
            const btn_envio = document.getElementById("envio");
            const btn_cancel = document.getElementById("cancel");

            btn_cancel.addEventListener("click", () => {
                location.reload(true);
            })

            btn_envio.addEventListener("click", (e) => {
                e.preventDefault();
                let claveData = new FormData(check);
                fetch('../src/users/check_key.php', {
                    method: 'POST',
                    body: claveData,
                })
                    .then(respuesta => respuesta.text())
                    .then(data => {
                        if (data == "ok") {
                            check.reset();
                            check.style.opacity = "0%";
                            check.style.top = "-49%";
                            regForm.style.opacity = "100%";
                            regForm.style.top = "-64%";
                            new_pass(consulta, log_user);
                        } else {
                            alert("La clave introducida es incorrecta.");
                            console.log("Clave incorrecta");
                        }
                    })
            })

            //new_pass(consulta, log_user);
        } else {
            alert("El e-mail no está registrado.")
        };

    }
})


const newUser = document.getElementById("newUser");
newUser.addEventListener("click", newReg);
const login = document.getElementById("login");
login.addEventListener("click", logueo);

entrar.addEventListener("click", entrando);
registro.addEventListener("click", registrando);
