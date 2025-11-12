<?php
require_once "src/Database/Conecta.php";
require_once "src/Services/UsuarioServico.php";
require_once "src/Helpers/Utils.php";
require_once "src/Services/AutenticacaoServico.php";

$usuarioServico= new UsuarioServico();


if($_SERVER['REQUEST_METHOD']==='POST'){
    if(empty($_POST['email'])||empty($_POST['senha'])){
        Utils::redirecionePara("login.php?campos_obrigatorios");
    }else{
      
        //Captura email e senha 
        $email =Utils::sanitizar( $_POST['email'],"email");
        $senha = $_POST['senha'];    
        //Busca pelo usuaario atraves do email 
        $verificar=$usuarioServico->verificarEmail($email);
        // se nao existir usuario/usuario invalido, redirecione para login
        if(!$verificar){
            Utils::redirecionePara("login.php?dados_incorretos");
        }else{   
            // Caso contrario, verifique a senha
            if(password_verify($senha,$verificar['SENHA']) ){
                // Estanto correto, faça o login
                AutenticacaoServico::login($verificar['ID'],$verificar['NOME'],$verificar['SENHA']);
            }else{
                // estando errada, mantenha em login.php
                Utils::redirecionePara("login.php?dados_incorretos");

            }

            
        }
     
    }
}




if(isset($_GET['acesso_proibido'])){
    $mensage = "Você deve logar primeiro";
}elseif(isset($_GET['campos_obrigatorios'])){
    $mensage = "E-mail e Senha devem ser preenchidos ";
}elseif(isset($_GET['dados_incorretos'])){
    $mensage = "E-mail/Senha errados";
}elseif(isset($_GET['saiu'])){
    $mensage = "Sessao Encerrada";
}
require_once "includes/cabecalho.php";
?>

<div class="row">
    <div class="bg-white rounded shadow col-12 my-1 py-4">
        <h2 class="text-center fw-light">Acesso à área administrativa</h2>

        <form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50" autocomplete="off">
		<?php if(isset($mensage)){ ?>
			<p class="alert alert-warning text-center my-2"><?=$mensage?></p>
		<?php } ?>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input class="form-control" type="email" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input class="form-control" type="password" id="senha" name="senha">
            </div>

            <button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>
        </form>
    </div>
</div>

<?php 
require_once "includes/rodape.php";
?>
