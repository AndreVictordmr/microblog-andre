<?php
// src/Model/Usuario.php
class Usuario{
    private string $nome;
    private string $email;
    private string $senha;
    private string $tipo;
    private ?int $id;


    public function __construct(string $nome,string $email,string $senha,string $tipo,?int $id=null){
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setTipo($tipo);
        $this->setId($id);


    }

    private function setNome(string $valor):void{$this->nome=$valor;}
    public function getNome():string{return $this->nome;}
    private function setEmail(string $valor):void{$this->email=$valor;}
    public function getEmail():string{return $this->email;}
    private function setSenha(string $valor):void{$this->senha=$valor;}
    public function getSenha():string{return $this->senha;}
    private function setTipo(string $valor):void{$this->tipo=$valor;}
    public function getTipo():string{return $this->tipo;}
    private function setId(?int $valor):void{$this->id=$valor;}
    public function getId():?int{return $this->id;}
}