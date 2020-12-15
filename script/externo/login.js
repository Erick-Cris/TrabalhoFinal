
window.onload = function () {
    var botaoEnviar = document.getElementById("entrar");
    botaoEnviar.addEventListener('click', validarUsuario);
}

function validarUsuario(event) {
    event.preventDefault();

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {

            try {
                var usuarioInvalido = document.getElementById("usuarioInvalido");
                var resultadoValidacao = JSON.parse(xmlhttp.responseText);

                if(!resultadoValidacao){
                    usuarioInvalido.style.display = 'inline-block';
                }
                else{
                    window.location.href = '../paginasInternas/index.html';
                }

            }
            catch (ex) {
                alert("A resposta do servidor não é válida: " + xmlhttp.responseText);
            }

        }
        else {
            alert("Ocorreu um erro ao carregar as especialidades: " + xmlhttp.status + xmlhttp.responseText);
        }
    }
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao carregar as especialidades");
    };
    xmlhttp.open("POST", "../data/externo/login.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("email=" + document.getElementById("usuario").value + "&senha=" + document.getElementById("senha").value);
}