<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>
    <title>GUIA ACADM</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>    
    <?php
        if (isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);       
        }   
    ?>
    <div class = "login-container">
    <img src="../image/logoGA.png" alt="Guia Academ Logo">
    <form method="POST" action="login.php">    
        <input type="text" placeholder="E-mail ou nome de usuário" name="login" required>         
        <input type="password" placeholder="Senha" name="senha1" required>    
        <input type="submit" value="Entrar" name="entrar" class="buttons">
    </form>
    <a href="../01cadastro/tela_cadastro.php"><button>Cadastrar</button></a>
    </div> 
</body>
</html>