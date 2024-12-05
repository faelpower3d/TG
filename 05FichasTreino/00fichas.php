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
    <title>Fichas de Treino</title>
    <link rel="stylesheet" href="../css/tela_ficha.css"> <!-- Link para o arquivo CSS -->
</head>
<body>
    <?php    
        include ("../conexao/academia.php");  
        $idd = $_SESSION['id'];        
        $query = "SELECT id, nome FROM aluno WHERE id = $idd"; 
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);         
        
        if ($row) {                  
            echo "";             
        } else {
            echo "ID não encontrado."; 
        }

        mysqli_close($con);    
    ?>     

    <div class="ficha-container">
        <img src="../image/logoGA2.png" alt="Logo"> <!-- Adicionar imagem de logo, se necessário -->
        
        <p>Bem-vindo: <?php echo $row['nome']; ?></p>

        <!-- Formulário para solicitar treino -->
        <form method="post">
            <input type="hidden" name="user_name" value="<?php echo $row['id']; ?>">
            <button type="submit" name="solicitar_treino">SOLICITAR TREINO</button>
        </form>

        <a href="01montar.php">
            <button type="button">MONTE SEU TREINO</button>
        </a>    

        <a href="../03home/home.php" class="voltar">
            <button type="button">Voltar</button>
        </a>

        <?php    
            // Verifica se o botão foi pressionado
            if (isset($_POST['solicitar_treino'])) {
                // Reabre a conexão com o banco
                include("../conexao/academia.php");
                
                // Captura o ID do aluno do campo oculto
                $nome_usuario = $_POST['user_name'];
                
                // Obtém a data atual
                $data_solicitacao = date('Y-m-d'); // Exemplo: 2024-11-22
                
                // Prepara a consulta para inserir a solicitação
                $query_insert_user = "INSERT INTO solicitacoes (id_aluno, data_solicitacao) VALUES ('$nome_usuario', '$data_solicitacao')";
                
                // Executa a inserção no banco
                $insert_user = mysqli_query($con, $query_insert_user);
                
                if ($insert_user) {
                    echo "<p>Solicitação de treino registrada com sucesso!</p>";
                } else {
                    // Captura e exibe a mensagem de erro caso o trigger bloqueie a inserção
                    echo "<p>Erro ao registrar a solicitação: " . mysqli_error($con) . "</p>";
                }
                
                // Fecha a conexão com o banco de dados
                mysqli_close($con);
            }
        ?>
    </div> 
</body>
</html>
