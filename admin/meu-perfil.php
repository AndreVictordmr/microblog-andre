<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Model/Usuario.php";
require_once "../src/Services/UsuarioServico.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";

AutenticacaoServico::exigirLogin();
$erro = null;
$usuarioServico = new UsuarioServico();
try {
	$dado=$usuarioServico->buscarId($_SESSION['id']);
	if(!$dado) $erro="Usuário não encontrado";
} catch (\Throwable $e) {
	$erro = "Erro: Falha ao buscar usuário.<br>". $e->getMessage();
}
if($_SERVER['REQUEST_METHOD']==='POST'){
	if(empty($_POST['nome'])||empty($_POST['email'])){
		$erro="Os campos Nome é e-mail  são obrigatorio";
	}else{
		try {
			$nome = Utils::sanitizar($_POST['nome']);
			$email = Utils::sanitizar($_POST['email'],'email');
			/* Se o campo estiver vazio, manter a senha existente. Caso contrário, verifique as senhas(digitada no form e a do banco)  */
			$senha = empty($_POST['senha']) ? $dado['SENHA'] : Utils::verificarSenha($_POST['senha'],$dado['SENHA']);

			//Monta os dados em um objeto do meu perfil(Meu tipo)
			$usuario = new Usuario($nome,$email,$senha,$dado['TIPO'],$_SESSION['id']);
			//Executa a atualizaçao
			$usuarioServico->atualizar($usuario);	
			// Forçando a atualizaçao da variavel de seçao
			$_SESSION['nome'] = $nome;
			// manda pra pagina de usuario
			Utils::redirecionePara('index.php');
		} catch (\Throwable $e) {
			$erro = "Erro: Falha ao carregar usuário.<br>". $e->getMessage();
		}
	}
}



require_once "../includes/cabecalho-admin.php";

?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Atualizar meus dados
		</h2>
		<?php if($erro){ ?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php } ?>
		<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
			<input type="hidden" name="id" value="<?= $dado['ID'] ?>">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input value="<?= $dado['NOME'] ?>" class="form-control" type="text" id="nome" name="nome">
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input value="<?= $dado['EMAIL']?>" class="form-control" type="email" id="email" name="email">
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>