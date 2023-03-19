<?php 
class Cadastro{
    private $nome;
    private $cnpj;
    private $telefone;
    private $email;
    private $estado;
    private $cidade;
    private $endereco;

    private static $inicioScript = "<script>";
    private static $fimScript = "</script>";

    function __construct($nome, $cnpj, $telefone, $email, $estado, $cidade, $endereco)
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->estado = $estado;
        $this->cidade = $cidade;
        $this->endereco = $endereco;
    }

    function getNome(){
        return $this->nome;
    }
    function getCnpj(){
        return $this->cnpj;
    }
    function getTelefone(){
        return $this->telefone;
    }
    function getEmail(){
        return $this->email;
    }
    function getEstado(){
        return $this->estado;
    }
    function getCidade(){
        return $this->cidade;
    }
    function getEndereco(){
        return $this->endereco;
    }


    function setNome($nome){
        $this->nome = $nome;
    }
    function setCnpj($cnpj){
        $this->cnpj = $cnpj;
    }
    function setTelefone($telefone){
        $this->telefone = $telefone;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function setEstado($estado){
        $this->estado = $estado;
    }
    function setCidade($cidade){
        $this->cidade = $cidade;
    }
    function setEndereco($endereco){
        $this->endereco = $endereco;
    }

    function criarObj($obj){
        $pessoaNome = "Nome: '".$obj->getNome()."', ";

        $pessoaCnpj = "Cnpj: '".$obj->getCnpj()."', ";

        $pessoaTelefone = "Telefone: ".$obj->getTelefone().", ";

        $pessoaEmail = "Email: '".$obj->getEmail()."', ";

        $pessoaEstado = "Estado: '".$obj->getEstado()."', ";

        $pessoaCidade = "Cidade: '".$obj->getCidade()."', ";

        $pessoaEndereco = "Endereco: '".$obj->getEndereco()."', ";

        $criarVariavelObj = "var pessoa = { ".$pessoaNome.$pessoaCnpj.$pessoaTelefone.$pessoaEmail.$pessoaEstado.$pessoaCidade.$pessoaEndereco."};";

        $script = Cadastro::$inicioScript.$criarVariavelObj.Cadastro::$fimScript;

        return $script;
    }

}

class CadastroPaciente{
    private $nome;
    private $genero;
    private $cpf;
    private $dtnascimento;
    private $naturalidade;
    private $estcivil;
    private $email;
    private $nmfisio;

    //private $email;

    private static $inicioScript = "<script>";
    private static $fimScript = "</script>";

    function __construct($nome, $genero, $cpf, $dtnascimento, $email, $naturalidade, $estcivil, $nmfisio)
    {
        $this->nome = $nome;
        $this->genero = $genero;
        $this->cpf = $cpf;
        $this->dtnascimento = $dtnascimento;
        $this->email = $email;
        $this->naturalidade = $naturalidade;
        $this->estcivil = $estcivil;
        $this->nmfisio = $nmfisio;
    }

    function getNome(){
        return $this->nome;
    }
    function getGenero(){
        return $this->genero;
    }
    function getCpf(){
        return $this->cpf;
    }
    function getDtnascimento(){
        return $this->dtnascimento;
    }
    function getNaturalidade(){
        return $this->naturalidade;
    }
    function getEstcivil(){
        return $this->estcivil;
    }
    function getEmail(){
        return $this->email;
    }
    function getNmfisio(){
        return $this->nmfisio;
    }


    function setNome($nome){
        $this->nome = $nome;
    }
    function setGenero($genero){
        $this->genero = $genero;
    }
    function setCpf($cpf){
        $this->cpf = $cpf;
    }
    function setDtnascimento($dtnascimento){
        $this->dtnascimento = $dtnascimento;
    }
    function setNaturalidade($naturalidade){
        $this->naturalidade = $naturalidade;
    }
    function setEstcivil($estcivil){
        $this->estcivil = $estcivil;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function setNmfisio($nmfisio){
        $this->nmfisio = $nmfisio;
    }

    function criarObj($obj){
        $pacienteNome = "Nome: '".$obj->getNome()."', ";

        $pacienteGenero = "Gênero: '".$obj->getGenero()."', ";

        $pacienteCpf = "Cpf: '".$obj->getCpf()."', ";

        $pacienteDtnascimento = "Dtnascimento: '".$obj->getDtnascimento()."', ";

        $pacienteEmail = "Email: '".$obj->getEmail()."', ";

        $pacienteNaturalidade = "Naturalidade: '".$obj->getNaturalidade()."', ";

        $pacienteEstcivil = "Estcivil: '".$obj->getEstcivil()."', ";

        $pacienteNmfisio = "nmfisio: '".$obj->getNmfisio()."', ";

        $criarVariavelObj = "var paciente = { ".$pacienteNome.$pacienteCpf.$pacienteDtnascimento.$pacienteEmail.$pacienteNaturalidade.$pacienteEstcivil.$pacienteNmfisio."};";

        $script = CadastroPaciente::$inicioScript.$criarVariavelObj.CadastroPaciente::$fimScript;

        return $script;
    }

}


?>