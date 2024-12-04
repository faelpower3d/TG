<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['id'])) {
        header("Location: ../02login/tela_login.php");
        exit(); 
    }
    if (isset($_SESSION['id'])) {
    
    include ("../conexao/academia.php");
    $id = $_SESSION['id']; 
  
    $result = "SELECT * FROM aluno WHERE id_cpf = '$id'";
    $resultado = mysqli_query($con, $result); 
    if (!$resultado) {
        die("Erro na consulta SQL: " . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($resultado);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obter dados do formulário
        $id = $_POST["id"];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $n = $_POST['n'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $id_ct = $_POST['id_ct'];
        $id_genero = $_POST['id_genero'];
        $idade = $_POST['idade'];
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];

        // Atualizar o registro no banco de dados
        $updateQuery = "UPDATE aluno SET 
            nome='$nome', sobrenome='$sobrenome', telefone='$telefone', cep='$cep', rua='$rua', n='$n', 
            cidade='$cidade', uf='$uf', id_ct='$id_ct', id_genero='$id_genero', idade='$idade', 
            peso='$peso', altura='$altura' WHERE id='$id'";

        $resultado = mysqli_query($con, $updateQuery);
        if (!$resultado) {
            die("Erro na atualização: " . mysqli_error($con));
        }

        if (mysqli_affected_rows($con) > 0) {
            $_SESSION['msg'] = "<p style='color:green;'>Cliente alterado com sucesso</p>";
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Cliente não foi alterado, verifique</p>";
        }
        
        header("Location: cliente.php?id=$id"); 
        exit();
    }
}
?>


<!DOCTYPE html> 
<html>
<head>
    <title>Home</title>
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
    <form method="POST" action="">  
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
        <label> Nome: </label>
        <input type="text" size="80" name="nome" value="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>         
        <br><label> Sobrenome: </label>
        <input type="text" size="80" maxlength="100" name="sobrenome" value="<?php echo htmlspecialchars($row['sobrenome'], ENT_QUOTES, 'UTF-8'); ?>" required>         
        <br><label> Telefone: </label>
        <input type="text" size="80" maxlength="15" name="telefone" id="telefone" oninput="aplicarFormatoTelefone(event)" value="<?php echo htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8'); ?>" required>     
        <br><label> CEP: </label>
        <input type="text" size="10" maxlength="8" id="cep" name="cep" onblur="buscarEndereco()" value="<?php echo htmlspecialchars($row['cep'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <br><label> Rua: </label>
        <input type="text" size="80" maxlength="100" id="rua" name="rua" value="<?php echo htmlspecialchars($row['rua'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
        <br><label> nº</label>
        <input type="text" size="20" maxlength="5" name="n" value="<?php echo htmlspecialchars($row['n'], ENT_QUOTES, 'UTF-8'); ?>" required> 
        <br><label> Cidade: </label>
        <input type="text" size="80" maxlength="100" id="cidade" name="cidade" value="<?php echo htmlspecialchars($row['cidade'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
        <br><label> Estado: </label>
        <input type="text" size="80" maxlength="2" id="estado" name="uf" value="<?php echo htmlspecialchars($row['uf'], ENT_QUOTES, 'UTF-8'); ?>" readonly>        
        <br><label> Selecione a academia: </label>
        <select name="id_ct">
            <?php
            $query = 'SELECT * FROM ct ORDER BY nome;';
            $resu = mysqli_query($con, $query);
            if (!$resu) {
                die("Erro na consulta SQL: " . mysqli_error($con));
            }
            while ($reg = mysqli_fetch_array($resu)) {
                $selected = ($reg['id'] == $row['id_ct']) ? 'selected' : '';
                echo "<option value=\"" . htmlspecialchars($reg['id'], ENT_QUOTES, 'UTF-8') . "\" $selected>" . htmlspecialchars($reg['nome'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            ?>
        </select>           
        <br><label> Gênero: </label>
        <select name="id_genero">
            <?php
            $query = 'SELECT * FROM genero ORDER BY genero;';
            $resu = mysqli_query($con, $query);
            if (!$resu) {
                die("Erro na consulta SQL: " . mysqli_error($con));
            }
            while ($reg = mysqli_fetch_array($resu)) {
                $selected = ($reg['id'] == $row['id_genero']) ? 'selected' : '';
                echo "<option value=\"" . htmlspecialchars($reg['id'], ENT_QUOTES, 'UTF-8') . "\" $selected>" . htmlspecialchars($reg['genero'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            ?>
        </select>          
        <br><label> Idade: </label>
        <input type="number" size="80" maxlength="2" name="idade" value="<?php echo htmlspecialchars($row['idade'], ENT_QUOTES, 'UTF-8'); ?>" required>          
        <br><label> Peso: </label>
        <input type="number" size="80" maxlength="4" name="peso" value="<?php echo htmlspecialchars($row['peso'], ENT_QUOTES, 'UTF-8'); ?>" required>          
        <br><label> Altura: </label>
        <input type="number" size="80" maxlength="4" name="altura" value="<?php echo htmlspecialchars($row['altura'], ENT_QUOTES, 'UTF-8'); ?>" required>          
        
        <p><input type="submit" value="Cadastrar"></p>
    </form>

    <a href="../03home/home.php"><input type="button" value="Voltar"></a>
</body>
</html>
