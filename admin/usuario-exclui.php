<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Model/Usuario.php";
require_once "../src/Services/UsuarioServico.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";

AutenticacaoServico::exigirLogin();
AutenticacaoServico::exigirAdmin();
$id=Utils::sanitizar($_GET['id'],'inteiro');
if(!$id) Utils::redirecionePara('usuarios.php');

$erro = null;
$sucesso = null;
$srevice = new UsuarioServico();

try {
	$srevice->excluir($id);

	$sucesso="Usuário excluido com sucesso";
} catch (\Throwable $e) {
	$erro = "Erro ao exclur usuario". $e->getMessage();
}

require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir usuário
		</h2>
		<?php if($erro){ ?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php } ?>
		<?php if($sucesso){ ?>
			<p class="alert alert-success text-center"><?=$sucesso?></p>
		<?php } ?>
			
		<a href="usuarios.php" class="btn btn-primary">Voltar</a>	
	</article>
</div>



<?php
require_once "../includes/rodape-admin.php";
?>