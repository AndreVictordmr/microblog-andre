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
}