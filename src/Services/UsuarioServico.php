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
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(':nome',$dados->getNome());
        $pega->bindValue(':email',$dados->getEmail());
        $pega->bindValue(':tipo',$dados->getTipo());
        $pega->bindValue(':senha',$dados->getSenha());
        $pega->execute();
        
    }
    // buscar(SELECT)
    public function buscar():array{
        $sql ="SELECT * FROM USUARIO ORDER BY nome";
        $pega=$this->conexao->query($sql);
        return $pega->fetchAll();
    }
    // buscarId(select/where)
    public function buscarId(INT $valor):?array{
        $sql ="SELECT * FROM USUARIO WHERE ID=:id";
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(":id",$valor);
        $pega->execute();

        /* Sobre '?:' conhecido como "Elvis Operator" É uma condicional simplificada/abreviada em que, se a condição/expressão for válida(ou seja, tem dados), ela mesma é retornada, Caso contrario, é retornado null*/
        return $pega->fetch() ?: null;
    }

    // AtualizarId(UPDATE)
    public function atualizar(Usuario $dado):void{
        $sql="UPDATE USUARIO SET NOME=:nome, EMAIL=:email, TIPO=:tipo, SENHA=:senha WHERE ID=:id ";
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(':nome',$dado->getNome());
        $pega->bindValue(':email',$dado->getEmail());
        $pega->bindValue(':tipo',$dado->getTipo());
        $pega->bindValue(':senha',$dado->getSenha());
        $pega->bindValue(':id',$dado->getId());
        $pega->execute();
    }

    public function excluir(int $valor){
        $sql ="DELETE FROM USUARIO WHERE ID=:id";
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(':id',$valor, PDO::PARAM_INT);
        $pega->execute();
    }
}