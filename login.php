<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logoicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login | Orthohand </title>
</head>

<body>

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
                    <h1>Login</h1>
                </div>
                <div class="cadastro-button">
                    <a href="cadastro.php"><button>Cadastro</button></a>
                </div>
            </div>

            <form id="form" action="configlogin.php" method="POST" class="form-login"> 
                <div class="input-group">

                    <div class="input-box">
                        <label for="email"> E-mail </label> 
                        <input id="email" type="text" name="email" placeholder="Email">
                    </div>
        
                    <div class="input-box">
                        <label for="password">Senha</label>
                        <input id="senha" type="password" name="senha" placeholder="Senha">
                    </div>

                </div>          

            <input class="btn-login" type="submit" name="submit" value="Enviar">
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/login.js"></script>
</body>

</html>