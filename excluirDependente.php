<?php
// Ativa a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['codResponsavel'])) {
    die("Acesso negado. Você precisa estar logado.");
}

// Configurações do banco de dados
$servername = "sql212.infinityfree.com";
$username = "if0_37379490";
$password = "F6rcghopPPm1puw";
$dbname = "if0_37379490_tcc_db";

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se um código de dependente foi fornecido
if (isset($_GET['codDependente']) && is_numeric($_GET['codDependente'])) {
    $codDependente = intval($_GET['codDependente']);

    // Prepara e executa a consulta de exclusão
    $sql = "DELETE FROM tb_dependente WHERE codDependente = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $codDependente);

        if ($stmt->execute()) {
            // Mensagem de sucesso
            $_SESSION['message'] = "Dependente excluído com sucesso!";
        } else {
            // Mensagem de erro
            $_SESSION['message'] = "Erro ao excluir dependente: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        $_SESSION['message'] = "Erro na preparação da declaração: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "Código de dependente inválido.";
}

// Fecha a conexão com o banco de dados
$conn->close();

// Redireciona de volta para a página de gerenciamento
header("Location: home.php");
exit();
?>
