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

}