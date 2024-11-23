<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>
<html>
<head>   
    <title>Fichas de Treino</title>
</head>
<?php
    if (!isset($_SESSION['id'])) {
        header("Location:../03aluno/index.html");            
    } else {                   
?>
<body>
    <?php    
        include ("../conexao/academia.php");  
        $idd = $_SESSION['id'];        
        $query = "SELECT id, nome FROM aluno WHERE id_cpf = $idd"; 
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);         
        
        if ($row) {                  
            echo "<p>Bem-vindo: " .$row['nome']."</p>";             
        } else {
            echo "id não encontrado."; 
        }

        mysqli_close($con);    
    ?>     

    <!-- Formulário para solicitar treino -->
    <form method="post">
        <!-- Passando o ID do usuário para o campo oculto -->
        <input type="hidden" name="user_name" value="<?php echo $row['id']; ?>">
        <button type="submit" name="solicitar_treino">SOLICITAR TREINO</button>
    </form>

    <a href="01montar.php"><input type="button" value="MONTE SEU TREINO"></a>    
    <a href="../03home/home.php"><input type="button" value="Voltar"></a>
    

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
</body>
</html>
<?php
    }
?>
