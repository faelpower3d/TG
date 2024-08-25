<?php
session_start();
include("../conexao/academia.php");

// Obtendo dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];  // Corrigido para email
$id_senha = $_POST['id_senha'];
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



// Função para limpar CPF
function limparCPF($cpf) {
    return preg_replace('/\D/', '', $cpf);
}

// Limpar o CPF
$cpf = limparCPF($cpf);

// Criptografar a senha
$senha = password_hash($id_senha, PASSWORD_DEFAULT);

// Verificar se o CPF já está registrado
$query_select = "SELECT id FROM usuarios WHERE cpf = '$cpf'";
$select = mysqli_query($con, $query_select);
$array = mysqli_fetch_array($select);
$id_usuario = $array['id'];

if ($id_usuario) {
    $_SESSION['msg'] = "Login já existente";
    header("Location: tela_cadastro.php");
    exit();  // Importante para evitar que o script continue executando
} else {
    // Inserir novo usuário
    $query_insert_user = "INSERT INTO usuarios (email, cpf, senha) VALUES ('$email', '$cpf', '$senha')";
    $insert_user = mysqli_query($con, $query_insert_user);

    if ($insert_user) {
        // Obter o ID do novo usuário inserido
        $id_usuario = mysqli_insert_id($con);

        // Inserir dados na tabela aluno
        $query_insert_aluno = "INSERT INTO aluno (nome, id_cpf, id_email, id_senha, telefone, cep, rua, n, cidade, uf, id_ct, id_genero, idade, peso, altura) 
                               VALUES ('$nome', '$id_usuario', '$id_usuario', '$id_usuario', '$telefone', '$cep', '$rua', '$n', '$cidade', '$uf', '$id_ct', '$id_genero', '$idade', '$peso', '$altura')";
        $insert_aluno = mysqli_query($con, $query_insert_aluno);

        if ($insert_aluno) {
            $_SESSION['msg'] = "<p>Usuário cadastrado com sucesso!</p>";
            header("Location: ../02login/tela_login.php");
        } else {
            $_SESSION['msg'] = "<p>Não foi possível cadastrar o aluno.</p>";
            header("Location: tela_cadastro.php");
        }
    } else {
        $_SESSION['msg'] = "<p>Não foi possível cadastrar o usuário.</p>";
        header("Location: tela_cadastro.php");
    }
}
?>

