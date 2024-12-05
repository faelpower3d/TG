<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['id'])) {
    include("../conexao/academia.php");
    $id = $_SESSION['id'];

    $result = "SELECT * FROM aluno WHERE id_cpf = '$id'";
    $resultado = mysqli_query($con, $result);
    if (!$resultado) {
        die("Erro na consulta SQL: " . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($resultado);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $id_genero = $_POST['id_genero'];
        $idade = $_POST['idade'];
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];

        $updateQuery = "UPDATE aluno SET 
            nome='$nome', telefone='$telefone', cidade='$cidade', uf='$uf', id_genero='$id_genero', idade='$idade', 
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../script/cep.js" defer></script>
    <script src="../script/cpf.js" defer></script>
    <script src="../script/tel.js" defer></script>
    <link rel="stylesheet" href="http://localhost/TG/css/tela_edit.css">
</head>
<body>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
    <div class = "edit-container">
        <h1>CADASTRO</h1>
        <img src="http://localhost/TG/image/logoGA2.png" alt="Guia Academ Logo">
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <label class="imc">Nome</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <hr>
        <label class="gen">Contato</label>
            <label class="imc">Telelfone</label>
            <input type="text" name="telefone" id="telefone" oninput="aplicarFormatoTelefone(event)" value="<?php echo htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <label class="gen">Local</label>
            <div class="form-group">
            <label class="imc">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($row['cidade'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
            <label class="imc">Estado</label>
            <input type="text" name="uf" id="estado" value="<?php echo htmlspecialchars($row['uf'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
            </div>
        <hr>
        <label class="gen">Gênero</label>
        <div class="gender-container">
            <label>
            <input type="radio" name="id_genero" value="<?php echo htmlspecialchars($row['id_genero'], ENT_QUOTES, 'UTF-8'); ?>"> Masculino
            </label>
            <br>
            <label><input type="radio" name="id_genero" value="<?php echo htmlspecialchars($row['id_genero'], ENT_QUOTES, 'UTF-8'); ?>"> Feminino</label>
        </div>
        <label class="gen">IMC</label>
        <div class="form-group">
            <label class="imc">Idade</label>
            <input type="number" name="idade" value="<?php echo htmlspecialchars($row['idade'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label class="imc">Peso</label>
            <input type="number" name="peso" step="0.1" value="<?php echo htmlspecialchars($row['peso'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label class="imc">Altura</label>
            <input type="number" name="altura" step="0.01" value="<?php echo htmlspecialchars($row['altura'], ENT_QUOTES, 'UTF-8'); ?>" required>           
        </div>
        <div class="button-group">
            <button type="submit" class="btn-submit">Atualizar</button>
            <button class="btn-back" type="button" onclick="window.location.href='../03home/home.php'">Voltar</button>
        </div>
    </form>
</div>
</body>
</html>
