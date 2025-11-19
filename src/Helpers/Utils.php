<?php
// src/Helpers/Utils.php
class Utils{

    /*Usamos mixed para sianlizar que o metodo aceita/retorna tipos de dados variados(string,int,array,float etc) */
    public static function sanitizar(mixed $valor, string $tipo='text'):mixed{
        switch ($tipo){
            case 'inteiro':
                return (int) filter_var($valor,FILTER_SANITIZE_NUMBER_INT);
            case 'email':
                return trim(filter_var($valor,FILTER_SANITIZE_EMAIL));
            default:                
                return trim(filter_var($valor,FILTER_SANITIZE_SPECIAL_CHARS)); 
        }
    }

    public static function codificarSenha(string $valor):string{
        return password_hash($valor, PASSWORD_DEFAULT);
    }

    public static function testarCoisa(mixed $valor):void{
        echo "<pre>";
        var_dump($valor);
        echo "</pre>";
    }

    public static function redirecionePara(string $valor):void{
        header("location:$valor");
        exit;
    }
    /* Ao chamar o método verificarSenha, passamos pra ele a senha digitada no formulario e a senha existente no bando */
    public static function verificarSenha(string $senhaNova,string $senhaAnterior):string{
        /* Usamos o password_verify para COMPARAR as duas senhas. */
        if(password_verify($senhaNova,$senhaAnterior)){
           // Caso elas sejam iguais retornamos a senha ja cadastrada
            return $senhaAnterior;
        }else{
            // caso sejam diferentes entao codificamos a nova senha
            return self::codificarSenha($senhaNova);
        }
    }

    public static function organizarData(string $data):string{
        return date("d/m/Y H:i",strtotime($data));
    }

    public static function upload(?array $arquivo): void {
        /*Validaçao inicial, verifica se:
            - Não tem arquivo
            - Não existe alguma referencia na area temporaria
            - Não for um arquivo que possa/permita envio/upload */
        if (!$arquivo || !isset($arquivo["tmp_name"]) ||!is_uploaded_file($arquivo["tmp_name"]) ) {
            throw new Exception("Nenhum arquivo válido foi enviado.");
        }
        // Definimos uma pasta no servidor/site para receber a imagem enviada
        $pastaDeDestino = "../images/";
        //Validação dos formados de imagems
        $formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        //Defenimos o tamanho maximo pra imagens
        $tamanhoMaximo = 2 * 1024 * 1024; // 2MB
        //Detectando o formato real do arquivo
        $formatoDoArquivoEnviado = mime_content_type($arquivo["tmp_name"]);
        // Se o formato não estiver na lista permitida ele da erro
        if (!in_array($formatoDoArquivoEnviado, $formatosPermitidos)) {
            throw new Exception("Apenas arquivos JPG, PNG, GIF e SVG são permitidos.");
        }
        // Se o tamanho do arquivo enviado for acima do enviado da erro
        if ($arquivo["size"] > $tamanhoMaximo) {
            throw new Exception("O arquivo é muito grande. Tamanho máximo: 2MB.");
        }
        //nesta momento criamos o nome do caminho que sera guardado na pasta
        $nomeDoArquivo = $pastaDeDestino . basename($arquivo["name"]);
        // Se não conseguir fazer uploaded, lança erro
        if (!move_uploaded_file($arquivo["tmp_name"], $nomeDoArquivo)) {
            throw new Exception("Erro ao mover o arquivo. Código de erro: " . $arquivo["error"]);
        }
    }
 
}