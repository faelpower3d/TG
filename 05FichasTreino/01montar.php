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
        
        // Consulta SQL para obter os exercícios
        $query = "SELECT * FROM exercicios"; 
        
        // Executar a consulta no banco de dados
        $result = mysqli_query($con, $query);
        
        // Verificar se há resultados
        if (mysqli_num_rows($result) > 0) {
            // Exibir os dados de cada exercício
            echo "<div class='exercicios'>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='exercicio'>";
                echo "<h2>" . $row['nome'] . "</h2>"; // Exibir o nome do exercício
                echo "<p>" . $row['descricao'] . "</p>"; // Exibir a descrição
                echo "<img src='" . $row['gif_url'] . "' alt='" . $row['nome'] . "' />"; // Exibir o GIF
                echo "</div>";
            }
            echo "</div>";
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
