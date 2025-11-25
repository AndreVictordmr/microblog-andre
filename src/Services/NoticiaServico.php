<?php

class NoticiaServico{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conecta::getConexao();
    }

    public function buscar(string $tipo,int $id):array{
        if($tipo === "admin"){
            $sql = "SELECT noticias.id, noticias.titulo, noticias.data, usuario.nome as autor from noticias join usuario on noticias.usuario_id = usuario.id  ORDER BY DATA DESC";
        }else{
            $sql = "SELECT id,titulo, data FROM NOTICIAS where usuario_id=:id order by data desc";
        }
        $pega = $this->conexao->prepare($sql);
        if($tipo !== "admin"){$pega->bindValue(":id",$id);}
        $pega->execute();
        return $pega->fetchAll();
    }

    public function mostrarNoticia(int $id):array{
        $sql = "SELECT noticias.id, noticias.titulo, noticias.data, usuario.nome, noticias.imagem,noticias.texto,noticias.resumo as autor from noticias join usuario on noticias.usuario_id = usuario.id  where id=:id";

        $pega = $this->conexao->prepare($sql);
        $pega->bindValue(":id",$id);
        $pega->execute();
        return $pega->fetch();
    }

    public function inserir(Noticia $dados):void{
        $sql ="INSERT INTO noticias(titulo, texto, resumo, imagem, usuario_id) VALUES (:titulo,:texto,:resumo,:imagem,:usuario_id)";
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(":titulo",$dados->getTitulo());
        $pega->bindValue(":texto",$dados->getTexto());
        $pega->bindValue(":resumo",$dados->getResumo());
        $pega->bindValue(":imagem",$dados->getImagem());
        $pega->bindValue(":usuario_id",$dados->getUsuarioId());
        $pega->execute();
    }

    public function buscarPorId(int $idNoticia,int $idUsuario,string $tipo):?array{
        if($tipo==="admin"){
            $sql = "SELECT * from noticias where id=:id";
        }else{
            $sql = "SELECT * FROM noticias where id=:id and usuario_id =:idUsa";
        }
        $pega = $this->conexao->prepare($sql);
        $pega->bindValue(":id",$idNoticia);
        if($tipo !== "admin") $pega->bindValue(":idUsa",$idUsuario);
        $pega->execute();
        return $pega->fetch() ?: null;
    }

    public function atualizar(Noticia $noticia, string $tipo):void{
        if($tipo==="admin"){
            $sql="UPDATE noticias set titulo=:titulo,texto=:texto,resumo=:resumo,imagem=:imagem where id=:id";
        }else{
            $sql="UPDATE noticias set titulo=:titulo,texto=:texto,resumo=:resumo,imagem=:imagem where id=:id and usuario_id = :valor";
        }
        $pega=$this->conexao->prepare($sql);
        $pega->bindValue(":titulo",$noticia->getTitulo());
        $pega->bindValue(":titulo",$noticia->getTitulo());
        $pega->bindValue(":texto",$noticia->getTexto());
        $pega->bindValue(":resumo",$noticia->getResumo());
        $pega->bindValue(":imagem",$noticia->getImagem());
        $pega->bindValue(":id",$noticia->getId());
        if($tipo !=="admin") $pega->bindValue(":valor",$noticia->getUsuarioId());
        $pega->execute();

    }
    
    public function excluir(int $id,int $UsaId, string $tipo):void{
        if($tipo ==="admin"){
            $sql="DELETE FROM noticias where id=:id";
        }else{
            $sql="DELETE from noticias where id=:id and usuarios_id=:valor";
        }
        $pega=$this->conexao->prepare($sql);

        $pega->bindValue(":id",$id);
        if($tipo !=="admin") $pega->bindValue(":valor",$UsaId);
        $pega->execute();
    }
}