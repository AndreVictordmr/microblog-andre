# Comandos usados para o projeto Microblog

## Modelagem Conceitual

### Criar o banco de dados

```sql
CREATE DATABASE microblog_andre CHARACTER SET utf8mb4;
```

### Criar a tabela usuarios

```sql
CREATE TABLE usuarios(
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(100) NOT NULL,
    EMAIL VARCHAR(100) NOT NULL UNIQUE,
    SENHA VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'editor') NOT NULL
);
```

### Criar a tabela noticias

```sql
CREATE TABLE noticia(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    resumo TEXT NOT NULL,
    texto TEXT NOT NULL,
    imagem VARCHAR(50) NOT NULL,
    data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,

    -- FK APONTA/REFERENCIA/ESTÁ LIGADA À PK de outra tabela
    FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
);
```