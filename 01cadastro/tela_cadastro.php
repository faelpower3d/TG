<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['id'])) {
        header("Location: ../02login/tela_login.php");
        exit(); 
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
    <form method="POST" action="cadastro.php">  
    <br><label> Nome: </label>
    <input type="text" size="80" maxlength="100" name="nome" required>         
    <br><label> sobrenome: </label>
    <input type="text" size="80" maxlength="100" name="sobrenome" required>         
        <br><label> CPF: </label>
        <input type="text" size="80" name="cpf" id="cpf" maxlength="14" oninput="aplicarFormatoCPF(event)" required>        
        <br><label> Email: </label>
        <input type="text" size="80" maxlength="100" name="email" required>        
        <br><label> Senha: </label>
        <input type="password" size="80" maxlength="100" name="id_senha" required>     
    <!--<br><label> Confirmar Senha: </label>
        <input type="password" size="80" maxlength="100" name="senha" required> -->  
        <br><label> Telefone: </label>
        <input type="text" size="80" maxlength="15" name="telefone" id="telefone" oninput="aplicarFormatoTelefone(event)" required>     
        <br><label> CEP: </label>
        <input type="text" size="10" maxlength="8" id="cep" name="cep" onblur="buscarEndereco()" required>
        <br><label> Rua: </label>
        <input type="text" size="80" maxlength="100" id="rua" name="rua" readonly>
        <br><label">nº</label>
        <input type="text" size="20" maxlength="5" name="n" required> 
        <br><label> Cidade: </label>
        <input type="text" size="80" maxlength="100" id="cidade" name="cidade" readonly>
        <br><label> Estado: </label>
        <input type="text" size="80" maxlength="2" id="estado" name="uf" readonly>        
        <br><label> Selecione a academia : </label>
        <select name="id_ct">
            <?php
            include ("../conexao/academia.php");
            $query = 'SELECT * FROM ct ORDER BY nome;';
            $resu = mysqli_query($con, $query) or die (mysqli_connect_error());
            while ($reg = mysqli_fetch_array($resu)) {
            ?>
                <option value="<?php echo $reg ['id'];?>"> <?php echo $reg ['nome'];?>
                </option>         
            <?php
            }
            mysqli_close($con);
            ?>
        </select>           
        <br><label> Gênero: </label>
        <select name="id_genero">
            <?php
            include ("../conexao/academia.php");
            $query = 'SELECT * FROM genero ORDER BY genero;';
            $resu = mysqli_query($con, $query) or die (mysqli_connect_error());
            while ($reg = mysqli_fetch_array($resu)) {
            ?>
                <option value="<?php echo $reg ['id'];?>"> <?php echo $reg ['genero'];?>
                </option>         
            <?php
            }
            mysqli_close($con);
            ?>
        </select>          
        <br><label> idade: </label>
        <input type="number" size="80" maxlength="2" name="idade"  required>          
        <br><label> Peso: </label>
        <input type="number" size="80" maxlength="4" name="peso" required>          
        <br><label> altura: </label>
        <input type="number" size="80" maxlength="4" name="altura" required>          
        
        <p><input type="submit" value="Cadastrar">
    </form>
    <a href="../02login/tela_login.php"><input type="button" value="Voltar"></a>

</body>
</html>