<?php
class Conecta {
    // 🔹 Atributos estáticos de configuração
    private static string $servidor = "localhost";
    private static string $banco = "microblog_andre";
    private static string $usuario = "root";
    private static string $senha = "";

    // 🔹 Atributo estático que armazenará a instância PDO
    private static ?PDO $conexao = null;

    // 🔹 Método estático que retorna a conexão
    public static function getConexao(): PDO {
        // Se ainda não há conexão, cria uma
        if (self::$conexao === null) {
            try {
                self::$conexao = new PDO(
                    "mysql:host=" . self::$servidor . ";dbname=" . self::$banco . ";charset=utf8",
                    self::$usuario,
                    self::$senha
                );

                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $erro) {
                die("Erro ao conectar: " . $erro->getMessage());
            }
        }

        // Retorna a mesma conexão (singleton)
        return self::$conexao;
    }

}
// Teste de conexao
Conecta::getConexao();
