<?php
    session_start(); 
    $login = $_POST['login'];
    $entar = $_POST['entrar'];
    $senha1 = $_POST['senha1'];   
    include ("../conexao/academia.php");
    if (isset($entar)){
        $query = "SELECT * FROM usuarios WHERE email = '$login' OR cpf = '$login'";
        $sql = mysqli_query($con, $query) or die("erro ! !");
        $row = mysqli_fetch_assoc($sql);
        $senha_bd=$row['senha'];                   
        if (password_verify($senha1, $senha_bd)) {             
                $_SESSION['id'] = $row['id'];
                header("location:../03home/home.php");                
        } else {
            $_SESSION["msg"] = "<p> login incorreto";
            header("Location:tela_login.php");
            
        }
    }
?>

