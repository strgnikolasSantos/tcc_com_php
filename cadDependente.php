<?php
// Configurações do banco de dados
$servername = "sql212.infinityfree.com"; // Nome do servidor do banco de dados
$username = "if0_37379490"; // Nome de usuário do banco de dados
$password = "F6rcghopPPm1puw"; // Senha do banco de dados
$dbname = "if0_37379490_tcc_db"; // Nome do banco de dados

// Criação da conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se houver um erro na conexão, interrompe a execução e exibe a mensagem de erro
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados enviados pelo formulário
    $nomeDependente = $_POST['nomeDependente']; // Nome do dependente
    $data_nascimento = $_POST['nascDependente']; // Data de nascimento do dependente
    $genero = $_POST['generoDependente']; // Gênero do dependente
    $grau_familiar = $_POST['descRelacao']; // Grau de parentesco
    $condicoes_saude = $_POST['condSaude']; // Condições de saúde do dependente
    $codResponsavel = $_POST['codResponsavel']; // Recebe o código do responsável do formulário

    // Prepara a declaração SQL para inserir os dados do dependente
    $stmt = $conn->prepare("INSERT INTO tb_dependente (nomeDependente, nascDependente, generoDependente, descRelacao, condSaude, codResponsavel) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt) {
        // Liga os parâmetros à consulta
        $stmt->bind_param("ssssss", $nomeDependente, $data_nascimento, $genero, $grau_familiar, $condicoes_saude, $codResponsavel);

        // Executa a declaração
        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, redireciona para a página home
            header("Location: home.php");
            exit(); // Interrompe a execução do script após o redirecionamento
        } else {
            // Se houver um erro ao executar a inserção, exibe a mensagem de erro
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        // Se houver erro na preparação da declaração, exibe a mensagem de erro
        echo "Erro na preparação da declaração: " . $conn->error;
    }
} else {
    // Se o formulário não foi enviado, captura o código do responsável da URL
    $codResponsavel = isset($_GET['codResponsavel']) ? $_GET['codResponsavel'] : 0; // Define como 0 se não estiver presente
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
