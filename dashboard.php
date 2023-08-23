<?php

session_start();

if(!isset($_SESSION['nome'])){
    header("Location: index.php");
    exit();
}

$nome = $_SESSION['nome'];

?>

<?php
require_once('classes/Editar.php');
require_once('conexao/conexao.php');

$database=new Conexao();
$db = $database->getConnection();
$crud=new Crud($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'read':
            $rows = $crud->read();
            break;
        
        case 'update':
            if(isset($_POST['id'])){
                $rows=$crud->update($_POST);
            }

            $rows=$crud->read();
            break;


            
        
        default:
        $rows = $crud->read();
        break;
    }
}else{
    $rows = $crud->read();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <style>
        form{
            max-width: 500px;
            margin: 0 auto;
        }

        body{
            max-width: 500px;
            margin:0 auto;
        }

        label{
            display: flex;
            margin-top: 10px;
        }

        input[type=text]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=email]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=password]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit]{
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
    
        }

        input[type=submit]:hover{
            background-color: #45a049;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin-top: 50px;
            margin-bottom: 10px;
        }
        th, td{
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th{
        
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .logout{
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: left;
        }

        a{
            display: inline-block;
            padding: 4px 8px;
            background-color: #007bff;
            color: #fff;
        }

        a:hover{
            background-color: #0069d9;
        }
        
     
       

    </style>
</head>
<body>

    
    <h2><p>Olá <?php echo $nome; ?></p></h2>
    

        <?php

            if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
                $id = $_GET['id'];
                $result = $crud->readOne($id);

                if(!$result){
                    echo "Registro não encontrado.";
                    exit();
                }

                $nome = $result['nome'];
                $email = $result['email'];
                $senha = $result['senha'];
                
            
        ?>

        <form action="?action=update" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">

            <label for="nome">Nome</label><input type="text" name="nome" value="<?php echo $nome ?>">
            <label for="email">Email</label><input type="email" name="email" value="<?php echo $email ?>">
            <label for="senha">Senha</label><input type="password" name="senha" maxlength = "8" value="<?php echo $senha ?>">


            <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
        </form>

        <?php
        }else{
        ?>



   
    <?php
        }
    ?>
    
    <table>
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Email</td>
            <td>Ação</td>
        </tr>

        <?php
            if($rows->rowCount() == 0){
                echo "<tr>";
                echo "<td colspan='7'>Nenhum dado encontrado</td>";
                echo "</tr>";
            } else {
                while($row = $rows->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    
                    echo "<td>";
                    echo "<a href='?action=update&id=" . $row['id'] . "'>Editar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
    
    <a class = "logout" href="logout.php">Sair</a>
</body>
</html>