<?php
//src/Services/UsuarioServico.php
class UsuarioServico{
    private PDO $conexao;

    /*Toda vez que criarmos um objeto baseado na classe UsuarioServico este objeto fará uma chamada ao método de conexão na classe Conecta   */
    public function __construct()
    {
        $this->conexao = Conecta::getConexao();
    }

    //inserir (INSERT)
    public function inserir(Usuario $dados):void{
        $sql = "INSERT INTO USUARIO(nome,email,tipo,senha) VALUES(:nome,:email,:tipo,:senha)";
        $conexao=$this->conexao->prepare($sql);
        $conexao->bindValue(':nome',$dados->getNome());
        $conexao->bindValue(':email',$dados->getEmail());
        $conexao->bindValue(':tipo',$dados->getTipo());
        $conexao->bindValue(':senha',$dados->getSenha());
        $conexao->execute();
        
    }
    // buscar(SELECT)
    public function buscar():array{
        $sql ="SELECT * FROM USUARIO ORDER BY nome";
        $conexao=$this->conexao->query($sql);
        return $conexao->fetchAll();
    }
}