<?php
require_once "src/Database/Conecta.php";
require_once "src/Model/Noticia.php";
require_once "src/Helpers/Utils.php";
require_once "src/Services/NoticiaServico.php";

$noticiaServico = new NoticiaServico();
$noticias = $noticiaServico->mostrarNoticia();


require_once "includes/cabecalho.php";
?>

<div class="row my-1 mx-md-n1">

    <!-- INÍCIO Card -->
    <?php foreach($noticias as $noticia){ ?>
    <div class="col-md-6 my-1 px-md-1">
        <article class="card shadow-sm h-100">
            <a href="noticia.php?id=<?=$noticia['id'] ?>" class="card-link">
                <img src="images/<?=$noticia['imagem']?>" class="card-img-top" alt="Imagem de capa do card">
                <div class="card-body">
                    <h3 class="fs-4 card-title"><?=$noticia['titulo']?></h3>
                    <p class="card-text"><?=$noticia['resumo']?></p>
                </div>
            </a>
        </article>
    </div>
    <?php } ?>
    <!-- FIM Card -->

</div>


<?php
require_once "includes/rodape.php";
?>