<?php

class NoticiaServico{
    private PDO $conexao;

    public function __construct()
    {
        $conexao = Conecta::getConexao();
    }

    public function buscar():array{
        $sql = "SELECT * from noticia ORDER BY DATA DESC.";
        $pega = $this->conexao->query($sql);
        return $pega->fetchAll();
    }
}