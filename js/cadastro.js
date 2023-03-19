var form = document.getElementById("form");

var nome = document.getElementById("nome");
var cnpj = document.getElementById("cnpj");
var tel = document.getElementById("telefone");
var email = document.getElementById("email");
var estado = document.getElementById("estado");
var cidade = document.getElementById("cidade");
var endereco = document.getElementById("endereco");
var senha = document.getElementById("senha");

form.addEventListener("submit", (e) => {
    const nomeValue = nome.value.trim();
    const cnpjValue = cnpj.value.trim();
    const telValue = tel.value.trim();
    const emailValue = email.value.trim();
    const estadoValue = estado.value.trim();
    const cidadeValue = cidade.value.trim();
    const enderecoValue = endereco.value.trim();
    const senhaValue = senha.value.trim();

    if(nomeValue === "" || cnpjValue === "" || telValue === "" || emailValue === "" || estadoValue === "" || cidadeValue === "" || enderecoValue === "" || senhaValue === ""){
        checkInputs();
        e.preventDefault();
    }
    else{
        if(validacao() == true){
            console.log(pessoa.Nome);
            console.log(pessoa.Cnpj);
            console.log(pessoa.Telefone)
            console.log(pessoa.Email);
            console.log(pessoa.Estado);
            console.log(pessoa.Cidade);
            console.log(pessoa.Endereco);
            alert("Cadastrado com sucesso");
            checkInputs();
            e.preventDefault();
        }
        else{
            checkInputs();
            e.preventDefault();
        }
    }
});


function checkInputs(){
    const nomeValue = nome.value.trim();
    const cnpjValue = cnpj.value.trim();
    const telValue = tel.value.trim();
    const emailValue = email.value.trim();
    const estadoValue = estado.value.trim();
    const cidadeValue = cidade.value.trim();
    const enderecoValue = endereco.value.trim();
    const senhaValue = senha.value.trim();

    if(nomeValue === ""){
        //erro
        setErrorFor(nome)
    } else{
        //certo
        setSucessFor(nome)
    }

    if(cnpjValue === ""){
        //erro
        setErrorFor(cnpj)
    } else{
        //certo
        validacao()    
    }

    if(telValue === ""){
        //erro
        setErrorFor(tel)
    } else{
        //certo
        setSucessFor(tel)
    }

    if(emailValue === ""){
        //erro
        setErrorFor(email)
    } else{
        //certo
        setSucessFor(email)
    }

    if(estadoValue === ""){
        //erro
        setErrorFor(estado)
    } else{
        //certo
        setSucessFor(estado)
    }

    if(cidadeValue === ""){
        //erro
        setErrorFor(cidade)
    } else{
        //certo
        setSucessFor(cidade)
    }

    if(enderecoValue === ""){
        //erro
        setErrorFor(endereco)
    } else{
        //certo
        setSucessFor(endereco)
    }

    if(senhaValue === ""){
        //erro
        setErrorFor(senha)
    } else{
        //certo
        setSucessFor(senha)
    }
}

function validacao(){
    var cnpjValue = cnpj.value.trim();
    //parte para ir para o banco de dados bunitinho
    //var cc = (cnpj.substr(0, 2)).concat(".") + (cnpj.substr(2, 3)).concat(".") + (cnpj.substr(5, 3).concat("/")) + (cnpj.substr(8, 4).concat("-")) + cnpj.substr(12, 2);
    //resp.innerHTML = cc; 

    //  1º DIGITO
    var seq = 6;
    var somatt = 0;
    for(var i = 0; i<13; i++){      

        var somacd = 0;

        if(i == 0){
            somacd = seq * 0;
        }
        else{
            /* Sequência da equacao do cnpj */
            let cnpjcortado = cnpjValue.substr(i-1, 1);

            somacd = seq * parseInt(cnpjcortado);
        }

        somatt = somatt + somacd;

        /* Sequencia para a verificação do CNPJ */
        if(seq > 2){
            seq--;
        }
        else{
            seq = 9;
        }
    }
    var resto1 = somatt % 11;
    

    if (resto1 <= 1){
        var digverificador = 0;
    }
    else{
        var digverificador = 11 - resto1;
    }

    var numver = cnpjValue.substr(12, 1);

    if(digverificador == numver){
        // 2º DIGITO
        var seq2 = 6;
        var somatt2 = 0;
        for(var c = 0; c < 13; c++){
            var somacd2 = 0;
            if(c == 12){
                somacd2 = seq2 * digverificador;
            }
            else{
                /* Seq2uência da equacao do cnpj */
                var cnpjcortado2 = cnpjValue.substr(c, 1);

                somacd2 = seq2 * parseInt(cnpjcortado2);
            }
    
            somatt2 = parseInt(somatt2) + somacd2;

            /* Sequencia para a verificação do CNPJ */
            if(seq2 > 2){
                seq2--;
            }
            else{
                seq2 = 9;
            }
        }
        var resto2 = somatt2 % 11;

        if (resto2 <= 1){
            var digverificador2 = 0;
        }
        else{
            var digverificador2 = 11 - resto2;
        }
        var numver2 = cnpjValue.substr(13, 1);
        //resp.innerHTML = "Dig Ver = " + digverificador2 + "numver = " + numver2;

        if(digverificador2 == numver2){
            setSucessFor(cnpj);
            return true;
        }
        else{
            setErrorFor(cnpj);
            return false;
        }
    }
    else{
        setErrorFor(cnpj);
        return false;
    }
}

function setErrorFor(input) {
    const inputBox = input.parentElement;

    inputBox.className = 'input-box error';
}

function setSucessFor(input){
    var inputBox = input.parentElement;

    inputBox.className = "input-box sucess";
}