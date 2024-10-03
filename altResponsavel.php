<?php
// Ativa a exibição de erros para depuração
ini_set('display_errors', 1); // Habilita a exibição de erros
ini_set('display_startup_errors', 1); // Habilita a exibição de erros durante a inicialização
error_reporting(E_ALL); // Define o nível de relatórios para todos os tipos de erros

// Inicia a sessão
session_start(); // Inicia uma nova sessão ou retoma a sessão existente

// Verifica se o usuário está logado
if (!isset($_SESSION['codResponsavel'])) {
    // Se o usuário não estiver logado, interrompe a execução e exibe uma mensagem
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
    // Se houver erro na conexão, interrompe a execução e exibe uma mensagem
    die("Conexão falhou: " . $conn->connect_error);
}

// Recupera o codResponsavel da sessão
$codResponsavel = $_SESSION['codResponsavel'];

// Recupera os dados enviados pelo formulário e aplica sanitização
$nomeResponsavel = filter_var($_POST['nomeResponsavel'], FILTER_SANITIZE_STRING); // Sanitiza o nome do responsável
$nasciResponsavel = $_POST['nasciResponsavel']; // Supondo que a data seja válida no formato yyyy-mm-dd
$emailResponsavel = filter_var($_POST['emailResponsavel'], FILTER_VALIDATE_EMAIL); // Valida e sanitiza o e-mail
$generoResponsavel = filter_var($_POST['generoResponsavel'], FILTER_SANITIZE_STRING); // Sanitiza o gênero do responsável

// Valida o e-mail
if (!$emailResponsavel) {
    // Se o e-mail não for válido, interrompe a execução e exibe uma mensagem
    die("E-mail inválido.");
}

// Prepara a consulta para atualizar os dados do responsável
$stmt = $conn->prepare("UPDATE tb_responsavel SET nomeResponsavel = ?, nasciResponsavel = ?, emailResponsavel = ?, generoResponsavel = ? WHERE codResponsavel = ?");
$stmt->bind_param("ssssi", $nomeResponsavel, $nasciResponsavel, $emailResponsavel, $generoResponsavel, $codResponsavel); // Liga os parâmetros à consulta

// Executa a consulta
if ($stmt->execute()) {
    // Se a atualização for bem-sucedida, redireciona para a página inicial com uma mensagem de sucesso
    header("Location: home.php?mensagem=Atualização realizada com sucesso");
    exit(); // Interrompe a execução do script após o redirecionamento
} else {
    // Se houver um erro na execução da consulta, exibe a mensagem de erro
    echo "Erro ao atualizar: " . $stmt->error;
}

// Fecha a conexão
$stmt->close(); // Fecha a declaração
$conn->close(); // Fecha a conexão com o banco de dados
?>
