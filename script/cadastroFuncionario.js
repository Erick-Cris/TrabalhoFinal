
        var flagMedico = document.getElementById("medico");
        flagMedico.addEventListener("change", apresentaCampos);
        var flag = flagMedico.checked;

        var crm = document.getElementById("campoCRM");
        var especialidade = document.getElementById("campoEspecialidade");

        function apresentaCampos(event) {
            if (flagMedico.checked) {
                especialidade.style.display = "inline-block";
                crm.style.display = "inline-block";
            }
            else {
                especialidade.style.display = "none";
                crm.style.display = "none";
            }
        }