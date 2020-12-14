
window.onload = function () {
    var campoCep = document.getElementById("cep");
    campoCep.addEventListener('keyup', buscarEndereco);
}

function buscarEndereco(event) {
    event.preventDefault();

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {

            campoLogradouro = document.getElementById("logradouro");
            campoBairro = document.getElementById("bairro");
            campoCidade = document.getElementById("cidade");
            campoEstado = document.getElementById("estado");

            try {
                var resultado = JSON.parse(xmlhttp.responseText);

                if(resultado[0])
                {
                    campoLogradouro.value = resultado[1];
                    campoBairro.value = resultado[2];
                    campoCidade.value = resultado[3];
                    campoEstado.value = resultado[4];
                }
            }
            catch (ex) {
                alert("A resposta do servidor não é válida: " + xmlhttp.responseText);
            }

        }
        else {
            alert("Ocorreu um erro ao carregar o endereço: " + xmlhttp.status + xmlhttp.responseText);
        }
    }
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao carregar o endereço");
    };
    xmlhttp.open("GET", "../data/interno/buscarEndereco.php?cep=" + document.getElementById("cep").value, true);
    xmlhttp.send();
}