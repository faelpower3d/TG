<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>   
    <title>Fichas de Treino</title>
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
    <a href="01montar.php"><input type="button" value="MONTE SEU TREINO"></a>
    <a href="02solicitar.php"><input type="button" value="SOLICITAR PLANO DE TREINO"></a>
    
    <a href="../03home/home.php"><input type="button" value="Voltar"></a>
</body>
</html>
<?php
    }
?>