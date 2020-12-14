
window.onload = function(){
    buscaEspecialidade();

    var campoEspecialidade = document.getElementById("especialidade");
    campoEspecialidade.addEventListener('change', buscaMedico);

    var campoData = document.getElementById('dataAgendamento');
    campoData.addEventListener('change', apresentarHorarios);    
}

function buscaEspecialidade() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {

            try {
                var campoEspecialidade = document.getElementById("especialidade");
                var especialidades = JSON.parse(xmlhttp.responseText);
                var option;


                option = document.createElement('option');
                option.textContent = "Selecione";
                campoEspecialidade.appendChild(option);
                for (var i = 0; i < especialidades.length; i++) {
                    option = document.createElement('option');
                    option.textContent = especialidades[i];
                    campoEspecialidade.appendChild(option);
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
    xmlhttp.open("GET", "../data/externo/buscaEspecialidade.php", true);
    xmlhttp.send();
}

function buscaMedico(event){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {

            try {
                var campoMedico = document.getElementById("medico");
                var nomes = JSON.parse(xmlhttp.responseText);
                var option;

                campoMedico.innerHTML = "";
                option = document.createElement('option');
                option.textContent = "Selecione";
                campoMedico.appendChild(option);
                for (var i = 0; i < nomes.length; i++) {
                    option = document.createElement('option');
                    option.textContent = nomes[i];
                    campoMedico.appendChild(option);
                }

                if(nomes.length > 0)
                    campoMedico.parentNode.style.display = 'inline-block';
                else
                    campoMedico.style.display = 'none';

            }
            catch (ex) {
                alert("A resposta do servidor não é válida: " + xmlhttp.responseText);
            }

        }
        else {
            alert("Ocorreu um erro ao carregar os médicos: " + xmlhttp.status + xmlhttp.responseText);
        }
    }
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao carregar os médicos");
    };
    var campoEspecialidade = document.getElementById("especialidade");
    xmlhttp.open("GET", "../data/externo/buscaMedico.php?especialidade=" + campoEspecialidade.value, true);
    xmlhttp.send();
}

function apresentarHorarios(){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onload = function () {
        if (xmlhttp.status == 200) {

            try {
                var campoHorario = document.getElementById("horario");
                var horariosOcupados = JSON.parse(xmlhttp.responseText);
                var option;
                var horariosFuncionamento = [8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                var horariosDisponiveis = [];
                var cont;
                
                for (var i = 0; i < horariosFuncionamento.length; i++) {
                    cont = 0;
                    for(var j = 0; j < horariosOcupados.length; j++){
                        if(horariosFuncionamento[i] == horariosOcupados[j])
                            cont++;                        
                    }
                    if(cont == 0)
                        horariosDisponiveis.push(horariosFuncionamento[i]);
                }

                campoHorario.innerHTML = "";
                option = document.createElement('option');
                option.textContent = "Selecione";
                campoHorario.appendChild(option);
                for(var i = 0; i < horariosDisponiveis.length; i++)
                {
                    option = document.createElement('option');
                    option.textContent = horariosDisponiveis[i];
                    campoHorario.appendChild(option);
                }                                    
            }
            catch (ex) {
                alert("A resposta do servidor não é válida: " + xmlhttp.responseText);
            }

        }
        else {
            alert("Ocorreu um erro ao carregar os horários: " + xmlhttp.status + xmlhttp.responseText);
        }
    }
    xmlhttp.onerror = function () {
        alert("Ocorreu um erro ao carregar os horários");
    };
    var campoMedico = document.getElementById("medico");
    var campoData = document.getElementById("dataAgendamento");
    xmlhttp.open("GET", "../data/externo/buscaHorario.php?medico=" + campoMedico.value + "&" + "data=" + campoData.value, true);
    xmlhttp.send();
}