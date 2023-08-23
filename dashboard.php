<?php

session_start();

if(!isset($_SESSION['nome'])){
    header("Location: index.php");
    exit();
}

$nome = $_SESSION['nome'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

    body{
        max-width: 500px;
        margin: 0 auto;
    }

    a{
            background-color: #1981CD;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: left;
            
    }


</style>
<body>
    <h1></h1>
    <h2>Olá <?php echo $nome; ?></h2>

    <a href="logout.php">Sair</a>


</body>
</html>