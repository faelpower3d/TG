<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<html>
<head>
    <title>GUIA ACADM</title>
</head>
<body>
    <p><h1>LOGIN</h1>
    <?php
        if (isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);       
        }   
    ?>
    <form method="POST" action="login.php">
    <label> Nome: </label>
        <input type="text" size="80" maxlength="100" name="login" required>  <br>      
        <br><label> Endereço: </label>
        <input type="password" size="80" maxlength="100" name="senha1" required>               
        </select>
        <p><input type="submit" value="Entrar" name="entrar">
    </form>
    <a href="../01cadastro/tela_cadastro.php"><button>Cadastrar</button></a> 
</body>
</html>