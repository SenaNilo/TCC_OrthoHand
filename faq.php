<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel="icon" href="img/logoicon.png">
    <title>Faq</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
 
    <link rel="stylesheet" href="css/faq.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
</head>
<body>
     <!-- NAVBAR -->
     <header>
        <nav>
            <a class="logo" href="index.html"><img class="imglogo" src="img/logoOrtoHand.png" alt="logo site Ortohand"></a>
            <ul class="nav-list">
                <li><a class="link" href="index.html"> Home </a></li>
                <li><a class="link" href="faq.html"> FAQ </a></li>  
                <li><a class="link" href="sobrenos.html"> Desenvolvedores </a></li>
                <li><a class="bt-login" href="login.php"> Login </a></li>
                <li><a class="bt-cadastro" href="cadastro.php"> Cadastre-se </a></li>
            </ul>
        </nav>
    </header>

     <!-- FAQ -->
     
     <div class="container" data-aos="fade-up">
        <div class="title-Faq">
            <h1 class="title">
                Perguntas frequentes
            </h1>
        </div>
        <!-- <main class="accordion"> -->

            <div class="faq-img">
                <img src="img/faq.svg" alt="" class="accordion-img">
            </div>
            <div class="content-accordion">
                <div class="question-answer">
                    <div class="question">
                        <h3 class="title-question">
                            Como funciona?/Como posso começar?
                        </h3>
                        <button class="question-btn">
                            <span class="up-icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                            <span class="down-icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                    </div>
                    <div class="answer">
                        <p>Você pode começar a utilizar indo até a sua clínica local, onde poderá ser informado sobre o sistema e podendo solicitar o seu cadastro, dessa forma, você receberá as informações necessárias para efetuar seu login em sua conta, tendo assim o acesso do sistema direto do conforto de sua casa.
                        </p>
                    </div>
                </div>
                <div class="question-answer">
                    <div class="question">
                        <h3 class="title-question">
                             Quais são os benefícios?
                        </h3>
                        <button class="question-btn">
                            <span class="up-icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                            <span class="down-icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                    </div>
                    <div class="answer">
                        <p>Nós oferecemos diversos recursos necessarios para o melhor conforto e gestão, como agenda, chat entre fisioterapeuta e paciente e descrições de seu 
                            monitoramento a cada consulta. Assim aumentando a eficácia do processo da fisioterapia ou melhoras do 
                            seu desempenho.</p>
                    </div>
                </div>
                <div class="question-answer">
                    <div class="question">
                        <h3 class="title-question">
                            O seu sistema é feito unicamente para as pessoas que utilizam prótese e órtese?
                        </h3>
                        <button class="question-btn">
                            <span class="up-icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                            <span class="down-icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                    </div>
                    <div class="answer">
                        <p>Não, nosso sistema abrange todas as pessoas
                             que precisam ou fazem fisioterapia, independente de ser permanente ou temporariamente.</p>
                    </div>
                </div>
                <div class="question-answer">
                    <div class="question">
                        <h3 class="title-question">
                                Problemas no acesso?
                        </h3>
                        <button class="question-btn">
                            <span class="up-icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                            <span class="down-icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                    </div>
                    <div class="answer">
                        <p>Abaixo temos nosso formulário de feedback em que você pode relatar seu problema, enviaremos nossa resposta. </p>
                    </div>
                </div>
                <div class="question-answer">
                    <div class="question">
                        <h3 class="title-question">
                                Qual a diferença deste sistema para Zoom, google meet, whatsapp? 
                        </h3>
                        <button class="question-btn">
                            <span class="up-icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                            <span class="down-icon">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                    </div>
                    <div class="answer">
                        <p>Nosso sistema é feito para este tipo de procedimento, além de ter vários benefícios como chat 
                            interativo, monitoramento, tudo isso feito e interagido de forma profissional </p>
                    </div>
                </div>
            </div>
        <!-- </main> -->
    </div>
    </div>

    <!-- Parte enviar mensagem de dúvidas.-->
    <div class="manipular">
    <div class="wrapper">
        <header>Ainda está com dúvidas? Envie uma mensagem à nossa equipe de Suporte.</header>
        <form
      action="https://formsubmit.co/OrthoHandDev@gmail.com"
      method="POST"
      class="form">
          <div class="dbl-field">
            <div class="field">
              <input type="text" class="input" name="name" id="name" placeholder="Digite seu nome">
              <i class='fas fa-user'></i>
            </div>
            <div class="field">
              <input type="email" class="input" id="email" name="email" placeholder="exemplo@gmail.com">
              <i class='fas fa-envelope'></i>
            </div>
          </div>
        
          <!--</div> -->
          <div class="message">
            <textarea placeholder="Digite sua mensagem" name="message"></textarea>
            <i class="material-icons"></i>
          </div>
          <div class="button-area">
          
            <input type="hidden" name="_captcha" value="false" />
      <input
        type="hidden"
        name="_next"
        value="http://localhost/TCC_OFC/obrigado.html"
      /> 
                    <button class="btnSolicitar" type="submit" href="obrigado.html">Enviar</button>
                
            </div>

          </div>
        </form>
      </div> 
</div>
<span></span>
    <!-- footer -->
    <div class="content5"> 
        <footer class="footer">
            <div class="container5">
                 <div class="row">

                    <div class="footer-col">
                        <h4>Serviços</h4>
                        <ul>
                            <li><a href="sobrenos.html">Sobre nós</a></li>
                        </ul>
                    </div>
  
                     <div class="footer-col">
                        <h4>Ajuda</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Feedback</a></li>
                        </ul>
                    </div>
  
            <div class="footer-col">
                <h4>Entrar</h4>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="cadastro.php">Cadastre-se</a></li>
                </ul>
            </div>
  
            <div class="footer-col">
                <h4>Siga-nos</h4>
                <div class="social-links">
                    <a href="sobrenos.html"><i class="fab fa-facebook-f"></i></a>
                    <a href="sobrenos.html"><i class="fab fa-instagram"></i></a>
                    <a href="sobrenos.html"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
              
            </div>
          </footer>
      </div>         
      <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
    });</script>
    <script src="main.js"></script>
    <script src="feedback.js"></script>
</body>
</html>