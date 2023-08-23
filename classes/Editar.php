<?php
include_once('conexao/conexao.php');

$db = new Conexao();
class Crud{
    private $conn;
    private $table_name ="usuario";

    public function __construct($db){
        $this->conn = $db;
    }

   

    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update($postValues){
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];
        $id = $postValues['id'];

        if(empty($nome) || empty($email) || empty($senha)){
            return false;
        }

        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $query = "UPDATE " . $this->table_name. " SET nome = ?, email = ?, senha = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senhaCriptografada);


        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        
    }

    public function readOne($id){
        $query = "SELECT * FROM ". $this->table_name. " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}

?>