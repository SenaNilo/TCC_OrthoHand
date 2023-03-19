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

    if(!empty($_POST['atualizarPaci'])){

        $val = new ValidarCPF();
        $cpf = $_POST['cpfPaci'];

        if($val -> ValidaCPF($cpf) == true){
            $id = $_POST['idPaci'];
            $nome = $_POST['nomePaci'];
            $email = $_POST['emailPaci'];
            $est_civil = $_POST['est_civilPaci'];
            $naturalidade = $_POST['natuPaci'];
            $genero = $_POST['generoPaci'];
            $idMedico = $_POST['nmFisioPaci'];
            $dt_nascimento = $_POST['dt_nascimentoPaci'];

            $sqlUpdatePaciente = "call editarUsuarioPaci('$id', '$nome','$cpf', '$dt_nascimento', '$genero', '$naturalidade', '$est_civil', '$email', '$idMedico')";

            $result = $conexao->query($sqlUpdatePaciente);
            header('Location: ../pacientes.php');
        }else{
            header('Location: ../pacientes.php');
        }
    }
    
?>