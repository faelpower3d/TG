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
    <title>Treinar Exercício</title>
</head>
<?php
if (!isset($_SESSION['id'])) {
    header("Location: ../03aluno/index.html");
} else {
    if (isset($_GET['id'])) {
        $exercicio_id = $_GET['id'];

        // Incluir a conexão com o banco de dados
        include ("../conexao/academia.php");

        // Consulta para obter os detalhes do exercício com base no ID
        $query = "
            SELECT 
                e.nome AS exercicio_nome,
                e.descricao AS exercicio_descricao,
                e.gif_url AS exercicio_gif
            FROM exercicios e
            WHERE e.id = '$exercicio_id'";

        $result = mysqli_query($con, $query);

        // Verificar se o exercício foi encontrado
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<h1>Exercício: " . $row['exercicio_nome'] . "</h1>";
            echo "<p>Descrição: " . $row['exercicio_descricao'] . "</p>";
            echo "<img src='" . $row['exercicio_gif'] . "' alt='" . $row['exercicio_nome'] . "' />";
        } else {
            echo "<p>Exercício não encontrado.</p>";
        }

        // Fechar a conexão
        mysqli_close($con);
    } else {
        echo "<p>Exercício não selecionado.</p>";
    }
}
?>

<a href="treinar.php"><input type="button" value="Voltar"></a>
</body>
</html>
