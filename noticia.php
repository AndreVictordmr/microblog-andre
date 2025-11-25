<?php
require_once "src/Database/Conecta.php";
require_once "src/Model/Noticia.php";
require_once "src/Helpers/Utils.php";
require_once "src/Services/NoticiaServico.php";

$noticiaServico = new NoticiaServico();
$id=Utils::sanitizar($_GET['id'],'inteiro');
if(!$id) Utils::redirecionePara("index.php");

$noticia=$noticiaServico->mostrarNoticiaPorId($id);


require_once "includes/cabecalho.php";
?>


<div class="row my-1 mx-md-n1">

    <article class="col-12">
        <h2><?= $noticia['titulo'] ?></h2>
        <p class="font-weight-light">
            <time><?= $noticia['data'] ?></time> - 
            <span><?= $noticia['autor'] ?></span>
        </p>
        <img src="images/<?= $noticia['imagem'] ?>" alt="" class="float-start pe-2 img-fluid">
        <p class="ajusta-texto"><?= $noticia['texto'] ?></p>
    </article>
    

</div>        
                  

<?php 
require_once "includes/rodape.php";
?>

