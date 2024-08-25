<?php
session_start();
include("../conexao/academia.php");

// Obtendo dados do formulário
$cpf = $_POST['cpf'];
$email = $_POST['email'];  // Corrigido para email
$id_senha = $_POST['id_senha'];


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
    } else {
        $_SESSION['msg'] = "<p>Não foi possível cadastrar o usuário.</p>";
        header("Location:../login/tela_login.php");
    }
}
?>
