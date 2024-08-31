<?php
session_start();
include("../conexao/academia.php");

// Função para limpar e validar dados de entrada
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Função para limpar CPF
function limparCPF($cpf) {
    return preg_replace('/\D/', '', $cpf);
}

// Obtendo e sanitizando os dados do formulário
$nome = sanitizeInput($_POST['nome']);
$cpf = limparCPF($_POST['cpf']);
$email = sanitizeInput($_POST['email']);  
$id_senha = $_POST['id_senha'];  // A senha não deve ser sanitizada, pois pode conter caracteres especiais
$telefone = sanitizeInput($_POST['telefone']);
$cep = sanitizeInput($_POST['cep']);
$rua = sanitizeInput($_POST['rua']);
$n = sanitizeInput($_POST['n']);
$cidade = sanitizeInput($_POST['cidade']);
$uf = sanitizeInput($_POST['uf']);
$id_ct = sanitizeInput($_POST['id_ct']);
$id_genero = sanitizeInput($_POST['id_genero']);
$idade = sanitizeInput($_POST['idade']);
$peso = sanitizeInput($_POST['peso']);
$altura = sanitizeInput($_POST['altura']);

// Criptografar a senha
$senha = password_hash($id_senha, PASSWORD_DEFAULT);

// Verificar se o CPF já está registrado usando prepared statements
$query_select = "SELECT id FROM usuarios WHERE cpf = ?";
$stmt_select = mysqli_prepare($con, $query_select);
mysqli_stmt_bind_param($stmt_select, "s", $cpf);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$array = mysqli_fetch_array($result);
$id_usuario = $array['id'];

if ($id_usuario) {
    $_SESSION['msg'] = "Login já existente";
    header("Location: tela_cadastro.php");
    exit();  // Importante para evitar que o script continue executando
} else {
    // Inserir novo usuário usando prepared statements
    $query_insert_user = "INSERT INTO usuarios (email, cpf, senha) VALUES (?, ?, ?)";
    $stmt_insert_user = mysqli_prepare($con, $query_insert_user);
    mysqli_stmt_bind_param($stmt_insert_user, "sss", $email, $cpf, $senha);
    $insert_user = mysqli_stmt_execute($stmt_insert_user);

    if ($insert_user) {
        // Obter o ID do novo usuário inserido
        $id_usuario = mysqli_insert_id($con);

        // Inserir dados na tabela aluno usando prepared statements
        $query_insert_aluno = "INSERT INTO aluno (nome, id_cpf, id_email, id_senha, telefone, cep, rua, n, cidade, uf, id_ct, id_genero, idade, peso, altura) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_aluno = mysqli_prepare($con, $query_insert_aluno);
        mysqli_stmt_bind_param($stmt_insert_aluno, "siiiissssssssdd", $nome, $id_usuario, $id_usuario, $id_usuario, $telefone, $cep, $rua, $n, $cidade, $uf, $id_ct, $id_genero, $idade, $peso, $altura);
        $insert_aluno = mysqli_stmt_execute($stmt_insert_aluno);

        if ($insert_aluno) {
            $_SESSION['msg'] = "<p>Usuário cadastrado com sucesso!</p>";
            header("Location: ../02login/tela_login.php");
        } else {
            $_SESSION['msg'] = "<p>Não foi possível cadastrar o aluno.</p>";
            header("Location: tela_cadastro.php");
        }

        mysqli_stmt_close($stmt_insert_aluno);
    } else {
        $_SESSION['msg'] = "<p>Não foi possível cadastrar o usuário.</p>";
        header("Location: tela_cadastro.php");
    }

    mysqli_stmt_close($stmt_insert_user);
}

mysqli_stmt_close($stmt_select);
mysqli_close($con);
?>
