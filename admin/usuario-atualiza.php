<?php
require_once "../src/Database/Conecta.php";
require_once "../src/Model/Usuario.php";
require_once "../src/Services/UsuarioServico.php";
require_once "../src/Helpers/Utils.php";
require_once "../src/Services/AutenticacaoServico.php";

AutenticacaoServico::exigirLogin();
AutenticacaoServico::exigirAdmin();
$id=Utils::sanitizar($_GET['id'],'inteiro');
//Se não houver um id valido na URL, faça voltar para a página usuarios
if(!$id) Utils::redirecionePara('usuarios.php');

$erro=null;
$usuarioServico = new UsuarioServico();

try {
	$dado=$usuarioServico->buscarId($id);
	if(!$dado) $erro="Usuário não encontrado";
} catch (\Throwable $e) {
	$erro = "Erro: Falha ao buscar usuário.<br>". $e->getMessage();
}

if($_SERVER['REQUEST_METHOD']==='POST'){
	if(empty($_POST['nome'])||empty($_POST['email'])||empty($_POST['tipo'])){
		$erro="Os campos Nome, e-mail e tipo são obrigatorio";
	}else{
		try {
			$nome = Utils::sanitizar($_POST['nome']);
			$email = Utils::sanitizar($_POST['email'],'email');
			$tipo = Utils::sanitizar($_POST['tipo']);
			/* Se o campo estiver vazio, manter a senha existente. Caso contrário, verifique as senhas(digitada no form e a do banco)  */
			$senha = empty($_POST['senha']) ? $dado['SENHA'] : Utils::verificarSenha($_POST['senha'],$dado['SENHA']);

			//Monta os dados em um objeto que sera atualizado
			$usuario = new Usuario($nome,$email,$senha,$tipo,$id);
			//Executa a atualizaçao
			$usuarioServico->atualizar($usuario);	
			// manda pra pagina de usuario
			Utils::redirecionePara('usuarios.php');
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
			Atualizar dados do usuário
		</h2>
		<?php if($erro){ ?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php } ?>
		<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar" autocomplete="off">
			<input type="hidden" name="id" value="<?=$dado['ID']?>">

			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input class="form-control" type="text" id="nome" name="nome" value="<?=$dado['NOME']?>">
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input class="form-control" type="email" id="email" name="email" value="<?=$dado['EMAIL']?>">
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<div class="mb-3">
				<label class="form-label" for="tipo">Tipo:</label>
				<select class="form-select" name="tipo" id="tipo">
					<option value=""></option>
					<option value="editor" <?php if($dado['TIPO'] ==='editor') echo 'selected';?>>Editor</option>
					<option value="admin" <?php if($dado['TIPO'] ==='admin') echo 'selected';?>>Administrador</option>
				</select>
			</div>

			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>