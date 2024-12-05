<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>
    <title>CADASTRO</title>    
    <script src="../script/tel.js" defer></script> 
    <link rel="stylesheet" href="../css/tela_cad.css">
    
</head>
<body>
    <?php
        if (isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);       
        }   
    ?>    
    <div class = "cadastro-container">
    <h1>CADASTRO</h1>
    <img src="../image/logoGA2.png" alt="Guia Academ Logo">
    <form method="POST" action="cadastro.php"> 
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password"  name="id_senha" placeholder="Senha" required>
    <hr>
        <label class="gen">Contato</label>
        <input type="text"  name="telefone" id="telefone" oninput="aplicarFormatoTelefone(event)" placeholder="Telefone" required>
        <label class="gen">Local</label>
        <div class="form-group">
        <input type="text"  id="cidade" name="cidade" placeholder="Cidade" required>
        <input type="text"  id="estado" name="uf" placeholder="Estado" required>
    </div>
    <hr>
    <label class="gen">Gênero</label>
        <div class="gender-container">
            <label>
            <input type="radio" name="id_genero" value="masculino"> Masculino
            </label>
            <br>
            <label><input type="radio" name="id_genero" value="feminino"> Feminino</label>
        </div>
        <label class="gen">IMC</label>
        <div class="form-group">
            <input type="number" name="idade" placeholder="Idade">
            <input type="number" name="peso" placeholder="Peso (kg)">
            <input type="number" name="altura" placeholder="Altura (cm)">
        </div>
        <div class="button-group">
            <button type="submit" class="btn-submit">Cadastrar</button>
            <button type="button" class="btn-back" onclick="window.location.href='../02login/tela_login.php'">Voltar</button>
            
        </div>
    </form>
</div>
</body>
</html>
