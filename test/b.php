<?php
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>
    <title>BEM VINDO</title>
    <script src="../script/cep.js" defer></script> 
    <script src="../script/cpf.js" defer></script> 
    <script src="../script/tel.js" defer></script> 
</head>
<body>
    <p><h1>CADASTRO</h1>
    <?php
        if (isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);       
        }   
    ?>
    <form method="POST" action="a.php">           
        <br><label> CPF: </label>
        <input type="text" size="80" name="cpf" id="cpf" maxlength="14" required>      <br>     
        <br><label> Email: </label>
        <input type="text" size="80" maxlength="100" name="email" required>        <br>    
        <br><label> Senha: </label>
        <input type="password" size="80" maxlength="100" name="id_senha" required>          <br>  
        <p><input type="submit" value="Cadastrar">
    </form>
    <a href="../login/tela_login.php"><button>Voltar</button></a> 
</body>
</html>