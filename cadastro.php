<?php 

// Se tiver submit vai enviar pro meu banco de dados
    if(isset($_POST['submit']))
    {
       // incluir a conexao 
        include_once('conexao.php');
        // agora vamos passar p banco de dados
        $nome = $_POST['nome']; 
        $cnpj = $_POST['cnpj'];
        $telefone = $_POST['telefone']; 
        $email = $_POST['email']; 
        $estado = $_POST['estado']; 
        $cidade = $_POST['cidade']; 
        $endereco = $_POST['endereco'];
        $senha = $_POST['senha']; 
        
        //Validação para ver se o campo está ou nao vazio
        if(empty($nome) || empty($cnpj) || empty($telefone) || empty($email) || empty($estado) || empty($cidade) || empty($endereco) || empty($senha)){
        }
        else{
            //AGORA O INSERT no banco -- Id_TpoUsu = 3 por conta que ele eh uma clinica
            $sqlCadClinica = "call CadClinica('$email', '$senha','$nome', '$cnpj', '$telefone', '$estado', '$cidade', '$endereco')";

            $result = $conexao->query($sqlCadClinica);

            header('Location: login.php'); 
        }
    }


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logoicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Cadastro | Orthohand </title>
</head>

<body>
<?php
    include_once('cadastrar.php');

    if(isset($_POST['submit']))
    {
        $nome = $_POST['nome']; 
        $cnpj = $_POST['cnpj'];
        $telefone = $_POST['telefone']; 
        $email = $_POST['email']; 
        $estado = $_POST['estado']; 
        $cidade = $_POST['cidade']; 
        $endereco = $_POST['endereco'];
        $senha = $_POST['senha']; 

        $pessoa = new Cadastro($nome, $cnpj, $telefone, $email, $estado, $cidade, $endereco);
        echo $pessoa->criarObj($pessoa);
    }
?> 
        <a href="index.html">
            <button class="cta">
                Voltar <i class="ri-arrow-right-line"></i>
            </button>
        </a>

    <div class="container">
        <div class="form-image">
            <img src="img/undraw_learning_re_32qv (1).svg" alt="">
        </div>
        <div class="form">
            
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastre-se</h1>
                    </div>
                    <div class="login-button">
                        <a href="login.php"><button>Entrar</button></a>
                    </div>
                </div>


                <form method="POST" class="form-cadastro" id="form">
                

                <div class="input-group">

                    <div class="input-box">
                       <label for="nome" class="labelInput">Nome da clínica: <span>*</span> </label>
                        <input type="text" name="nome" id="nome" class="inputUser" placeholder="Digite o nome">
                    </div>

                    <div class="input-box">
                        <label for="cnpj" class="labelInput">CNPJ: <span>*</span> </label>
                        <input type="text" name="cnpj" id="cnpj" placeholder="Digite o cnpj">
                    </div>

                    <div class="input-box">
                        <label for="telefone" class="labelInput">Telefone: <span>*</span> </label> 
                        <input type="tel" name="telefone" id="telefone" class="inputUser" placeholder="Telefone">
                    </div> 

                    <div class="input-box">
                        <label for="email" class="labelIput">E-mail: <span>*</span> </label>
                        <input type="email" name="email" id="email" placeholder="Digite o email">
                    </div>

                    <div class="input-box">
                        <label for="estado" class="labelInput">Estado: <span>*</span> </label>
                        <input type="text" name="estado" id="estado" class="inputUser" placeholder="Estado">
                    </div> 

                    <div class="input-box">
                        <label for="cidade" class="labelInput">Cidade: <span>*</span> </label>
                        <input type="text" name="cidade" id="cidade" class="inputUser" placeholder="Cidade">
                    </div>

                    <div class="input-box">
                        <label for="endereco" class="labelInput">Endereço: <span>*</span> </label>
                        <input type="text" name="endereco" id="endereco" class="inputUser" placeholder="Endereço">
                    </div> 
                        
                    <div class="input-box">
                        <label for="password" class="labelInput">Senha: <span>*</span> </label>
                        <input type="password" name="senha" id="senha" placeholder="Digite sua senha" minlength="8">
                    </div>

                </div>

                <div class="continue-button">
                    <input type="checkbox" required name="termos">
                    <label for="termos" class="labelTermos"> Li e concordo com os <a href="termospdf/TermosOrthoHand.pdf" target="_blank">Termos e Condições</a> do site. </label><br><br>
                    <input type="submit" name="submit" value="Cadastrar" class="btn-cadastrar" id="submit">
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/cadastro.js"></script>

</body>

</html>