<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Model/Noticia.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/NoticiaServico.php";
require_once "../src/Services/AutenticacaoServico.php";

AutenticacaoServico::exigirLogin();

$erro=null;
$noticiaServico = new NoticiaServico();






require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir notícia
		</h2>

			

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>