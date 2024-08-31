<?php
session_start(); 

// Função para limpar e validar dados de entrada
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if (isset($_POST['entrar'])) {
    $login = sanitizeInput($_POST['login']);
    $senha1 = $_POST['senha1'];   

    include ("../conexao/academia.php");

    // Usando prepared statements para evitar SQL injection
    $query = "SELECT * FROM usuarios WHERE email = ? OR cpf = ?";
    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $login, $login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $senha_bd = $row['senha'];

            if (password_verify($senha1, $senha_bd)) {
                // Regenerando o ID da sessão para prevenir fixação de sessão
                session_regenerate_id(true);
                $_SESSION['cpf'] = $row['cpf'];
                header("location:../03aluno/index.html");
                exit;
            } else {
                $_SESSION["msg"] = "<p>Login incorreto</p>";
                header("Location:tela_login.php");
                exit;
            }
        } else {
            $_SESSION["msg"] = "<p>Usuário não encontrado</p>";
            header("Location:tela_login.php");
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Erro na consulta ao banco de dados!");
    }

    mysqli_close($con);
} else {
    header("Location:tela_login.php");
    exit;
}
?>
