<?php
    include_once('../../../conexao.php');

    /* Validacao do CPF */
		class ValidarCPF{
			function validaCPF($cpf) {
		
				// Extrai somente os números
				$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
				
				// Verifica se foi informado todos os digitos corretamente
				if (strlen($cpf) != 11) {
					return false;
				}
		
				// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
				if (preg_match('/(\d)\1{10}/', $cpf)) {
					return false;
				}
		
				// Faz o calculo para validar o CPF
				for ($t = 9; $t < 11; $t++) {
					for ($d = 0, $c = 0; $c < $t; $c++) {
						$d += $cpf[$c] * (($t + 1) - $c);
					}
					$d = ((10 * $d) % 11) % 10;
					if ($cpf[$c] != $d) {
						return false;
					}
				}
				return true;
			}
		}
	/* * */

    if(!empty($_POST['atualizarFisio'])){

        $val = new ValidarCPF();
        $cpf = $_POST['cpfFisio'];

        if($val -> ValidaCPF($cpf) == true){
            $id = $_POST['idFisio'];
            $nome = $_POST['nomeFisio'];
            $crefito = $_POST['crefitoFisio'];
            $dt_nascimento = $_POST['dt_nascimentoFisio'];
            $genero = $_POST['generoFisio'];
            $email = $_POST['emailFisio'];

            $sqlUpdateFisio = "call editarUsuarioFisio('$id', '$nome','$cpf', '$crefito', '$dt_nascimento', '$genero', '$email')";

            $result = $conexao->query($sqlUpdateFisio);
            header('Location: ../medicFisio.php');
        }else{
            header('Location: ../medicFisio.php');
        }
    }
    
?>