<?php
// Ativa a exibição de erros para ajudar na depuração
ini_set('display_errors', 1); // Exibe erros durante a execução do script
ini_set('display_startup_errors', 1); // Exibe erros durante a inicialização do script
error_reporting(E_ALL); // Reporta todos os tipos de erros

// Inicia uma nova sessão ou retoma a sessão existente
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['codResponsavel'])) {
    // Se o usuário não estiver logado, exibe uma mensagem e interrompe a execução
    die("Acesso negado. Você precisa estar logado.");
}

// Configurações do banco de dados
$servername = "sql212.infinityfree.com"; // Nome do servidor do banco de dados
$username = "if0_37379490"; // Nome de usuário do banco de dados
$password = "F6rcghopPPm1puw"; // Senha do banco de dados
$dbname = "if0_37379490_tcc_db"; // Nome do banco de dados

// Criação da conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se houver erro na conexão, exibe uma mensagem e interrompe a execução
    die("Conexão falhou: " . $conn->connect_error);
}

// Recupera o código do dependente enviado pelo formulário
$codDependente = $_POST['codDependente']; // ID do dependente que será atualizado

// Recupera e sanitiza os dados enviados pelo formulário
$nomeDependente = filter_var($_POST['nomeDependente'], FILTER_SANITIZE_STRING); // Nome do dependente
$nascDependente = $_POST['nascDependente']; // Data de nascimento do dependente (formato yyyy-mm-dd)
$descRelacao = filter_var($_POST['descRelacao'], FILTER_SANITIZE_STRING); // Descrição da relação
$generoDependente = filter_var($_POST['generoDependente'], FILTER_SANITIZE_STRING); // Gênero do dependente
$condSaude = filter_var($_POST['condSaude'], FILTER_SANITIZE_STRING); // Condição de saúde do dependente

// Prepara a consulta SQL para atualizar os dados do dependente
$stmt = $conn->prepare("UPDATE tb_dependente SET nomeDependente = ?, nascDependente = ?, descRelacao = ?, generoDependente = ?, condSaude = ? WHERE codDependente = ?");

// Liga os parâmetros à consulta preparada
$stmt->bind_param("sssssi", $nomeDependente, $nascDependente, $descRelacao, $generoDependente, $condSaude, $codDependente);

// Executa a consulta
if ($stmt->execute()) {
    // Se a execução for bem-sucedida, redireciona para a página inicial com uma mensagem de sucesso
    header("Location: home.php?mensagem=Atualização do dependente realizada com sucesso.");
    exit(); // Interrompe a execução do script
} else {
    // Se ocorrer um erro, exibe uma mensagem com o erro
    echo "Erro ao atualizar: " . $stmt->error;
}

// Fecha a declaração e a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
