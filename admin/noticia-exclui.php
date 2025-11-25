<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Model/Noticia.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/NoticiaServico.php";
require_once "../src/Services/AutenticacaoServico.php";

AutenticacaoServico::exigirLogin();

$erro=null;
$sucesso=null;
$noticiaServico = new NoticiaServico();
$id=Utils::sanitizar($_GET['id'],'inteiro');
if(!$id) Utils::redirecionePara("noticias.php");

try {
	$noticiaServico->excluir($id,$_SESSION['id'],$_SESSION['tipo']);

	$sucesso="Noticia excluida com sucesso!";
} catch (\Throwable $e) {
	$erro="Erro ao tentar excluir a noticia".$e->getMessage();
}

require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir notícia
		</h2>
		<?php if($erro){ ?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php } ?>
		<?php if($sucesso){ ?>
			<p class="alert alert-success text-center"><?=$sucesso?></p>
		<?php } ?>
			

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>