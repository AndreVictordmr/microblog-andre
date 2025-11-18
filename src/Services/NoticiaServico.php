<?php

class NoticiaServico{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conecta::getConexao();
    }

    public function buscar():array{
        $sql = "SELECT noticia.id, noticia.titulo, noticia.data, usuario.nome as autor from noticia join usuario on noticia.usuario_id = usuario.id  ORDER BY DATA DESC";
        $pega = $this->conexao->query($sql);
        return $pega->fetchAll();
    }


}