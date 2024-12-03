<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<html>
<head>   
    <title>Home</title>
</head>
<?php
if (!isset($_SESSION['id'])) {
    header("Location:../03aluno/index.html");            
} else {                   
?>
<body>
    <?php    
    // Incluir a conexão com o banco de dados
    include ("../conexao/academia.php"); 
    
    // Obter o ID do usuário da sessão
    $id = $_SESSION['id'];        

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Processar os exercícios marcados
        if (!empty($_POST['exercicios']) && !empty($_POST['dias_da_semana'])) {
            $dia_id = $_POST['dias_da_semana']; // ID do dia da semana selecionado
            foreach ($_POST['exercicios'] as $exercicio_id) {
                // Inserir o exercício marcado e o dia na tabela "meus_exercicios"
                $query_insert = "INSERT INTO meus_exercicios (user_id, exercicio_id, dias_da_semana_id) 
                                 VALUES ('$id', '$exercicio_id', '$dia_id')";
                mysqli_query($con, $query_insert);
            }
            echo "Exercícios salvos com sucesso!";
        } else {
            echo "Selecione pelo menos um exercício e um dia da semana.";
        }
    }
    
    // Consulta SQL para obter os exercícios
    $query_exercicios = "SELECT * FROM exercicios"; 
    $result_exercicios = mysqli_query($con, $query_exercicios);

    // Consulta SQL para obter os dias da semana
    $query_dias = "SELECT * FROM dias_da_semana"; 
    $result_dias = mysqli_query($con, $query_dias);
    
    // Verificar se há exercícios
    if (mysqli_num_rows($result_exercicios) > 0) {
        echo "<form method='POST' action=''>"; // Formulário começa aqui

        // Exibir os exercícios
        echo "<div class='exercicios'>";
        while ($row = mysqli_fetch_assoc($result_exercicios)) {
            echo "<div class='exercicio'>";  
            echo '<input type="checkbox" name="exercicios[]" value="' . $row['id'] . '">';                              
            echo "<h2>" . $row['nome'] . "</h2>"; // Exibir o nome do exercício
            echo "<p>" . $row['descricao'] . "</p>"; // Exibir a descrição
            echo "<img src='" . $row['gif_url'] . "' alt='" . $row['nome'] . "' />"; // Exibir o GIF
            echo "</div>";
        }
        echo "</div>";

        // Exibir o select dos dias da semana
        echo "<div class='dias-semana'>";
        echo "<label for='dias_da_semana'>Escolha um dia da semana:</label>";
        echo "<select name='dias_da_semana' id='dias_da_semana' required>";
        echo "<option value=''>-- Selecione --</option>";
        while ($row = mysqli_fetch_assoc($result_dias)) {
            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
        }
        echo "</select>";
        echo "</div>";

        echo '<button type="submit">Salvar Exercícios</button>'; // Botão para enviar o formulário
        echo "</form>";
    } else {
        echo "Nenhum exercício encontrado.";
    }
    
    // Fechar a conexão
    mysqli_close($con);
    ?>
</body>
</html>
<?php
} // Fecha o else de verificação da sessão
?>
