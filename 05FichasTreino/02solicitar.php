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
           
        
            echo "<p>Uhul! " .$row['nome']."Sua solicitação foi aceita!!</p>"
            ?> 
     
Em breve um dos nossos personais cadastrados receberá sua solicitação e montará seu plano de treino exclusivo;

    <br>
    <a href="../03home/home.php"><input type="button" value="Voltar"></a>
</body>
</html>
<?php
}
?>