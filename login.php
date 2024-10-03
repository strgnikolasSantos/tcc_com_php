<?php
// Ativa a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os valores do formulário
    $email = $_POST['email'];
    $senha = $_POST['pswResponsavel']; // Senha em texto simples

    // Prepara a consulta no banco de dados
    $stmt = $conn->prepare("SELECT pswResponsavel, codResponsavel FROM tb_responsavel WHERE emailResponsavel = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o e-mail existe no banco de dados
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($senhaArmazenada, $codResponsavel);
        $stmt->fetch();

        // Debug: mostre a senha digitada e a armazenada
        echo "Senha digitada: " . htmlspecialchars($senha) . "<br>";
        echo "Senha armazenada: " . htmlspecialchars($senhaArmazenada) . "<br>";

        // Verifica se a senha digitada é igual à armazenada
        if ($senha === $senhaArmazenada) {
            // A senha está correta
            session_start();
            $_SESSION['codResponsavel'] = $codResponsavel; // Armazena o código do responsável na sessão
            header("Location: home.php"); // Redireciona para a área logada
            exit; // Sempre use exit após redirecionamento
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "E-mail não encontrado.";
    }

    // Fecha a consulta
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
