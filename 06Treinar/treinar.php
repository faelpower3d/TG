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
    <title>Meus Exercícios</title>
</head>
<?php
if (!isset($_SESSION['id'])) {
    header("Location:../03aluno/index.html");
} else {
?>
<body>
    <h1>Meus Exercícios</h1>

    <form method="GET" action="">
        <button type="submit" name="dia" value="Segunda">S</button>
        <button type="submit" name="dia" value="Terça">T</button>
        <button type="submit" name="dia" value="Quarta">Q</button>
        <button type="submit" name="dia" value="Quinta">Q</button>
        <button type="submit" name="dia" value="Sexta">S</button>
        <button type="submit" name="dia" value="Sábado">S</button>
        <button type="submit" name="dia" value="Domingo">D</button>
    </form>

    <?php
    include ("../conexao/academia.php");
    $id = $_SESSION['id'];
    $dia_selecionado = isset($_GET['dia']) ? $_GET['dia'] : '';

    if ($dia_selecionado) {
        $query = "
            SELECT 
                e.id AS exercicio_id, e.nome AS exercicio_nome,
                e.descricao AS exercicio_descricao, e.gif_url AS exercicio_gif,
                d.nome AS dia_nome
            FROM meus_exercicios me
            INNER JOIN exercicios e ON me.exercicio_id = e.id
            INNER JOIN dias_da_semana d ON me.dias_da_semana_id = d.id
            WHERE me.user_id = '$id' AND d.nome = '$dia_selecionado'
            ORDER BY e.nome";
    } else {
        $query = "
            SELECT 
                e.id AS exercicio_id, e.nome AS exercicio_nome,
                e.descricao AS exercicio_descricao, e.gif_url AS exercicio_gif,
                d.nome AS dia_nome
            FROM meus_exercicios me
            INNER JOIN exercicios e ON me.exercicio_id = e.id
            INNER JOIN dias_da_semana d ON me.dias_da_semana_id = d.id
            WHERE me.user_id = '$id'
            ORDER BY d.id, e.nome";
    }

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='meus-exercicios'>";
        while ($row = mysqli_fetch_assoc($result)) {
            // Envolver toda a div com a tag <a> para torná-la clicável
            echo "<a href='02treinar.php?id=" . $row['exercicio_id'] . "'>";
            echo "<div class='exercicio'>";
            echo "<h2>" . $row['exercicio_nome'] . "</h2>";
            echo "<p>Descrição: " . $row['exercicio_descricao'] . "</p>";
            
            echo "<img src='" . $row['exercicio_gif'] . "' alt='" . $row['exercicio_nome'] . "' />";
            echo "</div>";
            echo "</a>";
        }
        echo "</div>";
    } else {
        echo "<p>Você ainda não adicionou nenhum exercício para este dia.</p>";
    }

    mysqli_close($con);
    ?>

    <a href="../03home/home.php"><input type="button" value="Voltar"></a>
</body>
</html>
<?php
} 
?>
