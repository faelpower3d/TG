<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>   
    <title>Home</title>
</head>
    <?php
        if (!isset($_SESSION['id'])) {
            header("Location:../03aluno/index.html");            
        }else{                   
    ?>
<body>
    <?php    
        include ("../conexao/academia.php");; 
        $id = $_SESSION['id'];        
        $query = "SELECT nome FROM aluno WHERE id_cpf = $id"; 
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);         
        if ($row) {                  
            echo "<p>Bem vindo: " .$row['nome']."</p>";             
            }else {
                echo "id não encontrado."; 
            }mysqli_close($con);    
    ?>
    <a href="../test.html"><input type="button" value="TREINAR"></a>    
    <a href="../05FichasTreino/00fichas.php"><input type="button" value="FICHAS DE TREINO"></a>
    <a href="../test.html"><input type="button" value="MEUS RESULTADOS"></a>
    <a href="../04aluno/back/cadastro.php"><input type="button" value="MEU CADASTRO"></a>
    <a href="../02login/tela_login.php"><input type="button" value="Voltar"></a>
    
</body>
</html>
<?php
    }
?>