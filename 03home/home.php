<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>   
    <title>Home</title>
    <link rel="stylesheet" href="../css/tela_home.css">
</head>
<?php
        if (!isset($_SESSION['id'])) {
            header("Location:../02login/tela_login.php");            
        }else{                   
    ?>
<body>
    
<div class="home-container">
<img src="../image/logoGA2.png" alt="Guia Academ Logo">

    <div class="buttons">
        <button class="register-button" onclick="window.location.href='../06Treinar/treinar.php';">TREINAR</button>
        <button class="register-button" onclick="window.location.href='../05FichasTreino/00fichas.php';">FICHAS DE TREINO</button>
        <button class="register-button" onclick="window.location.href='../test.html';">MEUS RESULTADOS</button>
        <button class="register-button" onclick="window.location.href='../04aluno/cadastro.php';">MEU CADASTRO</button>
    </div>
    <div class="voltar">
        <button class="register-button" onclick="window.location.href='../02login/tela_login.php';" name="voltar" >VOLTAR</button>
    </div>
</div>
</body>
</html>
<?php
    }
?>