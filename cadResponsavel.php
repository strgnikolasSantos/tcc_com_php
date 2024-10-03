<?php
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
    $nome = filter_var(trim($_POST['nomeResponsavel']), FILTER_SANITIZE_STRING);
    $data_nascimento = filter_var($_POST['nasciResponsavel'], FILTER_SANITIZE_STRING);
    $genero = filter_var($_POST['generoResponsavel'], FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['emailResponsavel']), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['pswResponsavel']; // Senha em texto simples

    // Verifica se o e-mail é válido
    if (!$email) {
        die("E-mail inválido.");
    }

    // Prepara e executa a inserção
    $stmt = $conn->prepare("INSERT INTO tb_responsavel (nomeResponsavel, nasciResponsavel, emailResponsavel, generoResponsavel, pswResponsavel) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sssss", $nome, $data_nascimento, $email, $genero, $senha);

        if ($stmt->execute()) {
            // Obtém o código do responsável recém-inserido
            $codResponsavel = $conn->insert_id; // Obtém o ID gerado automaticamente

            // Redireciona para o formulário de dependente com o código do responsável
            header("Location: formDependente.php?codResponsavel=" . urlencode($codResponsavel));
            exit();
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da declaração: " . $conn->error;
    }
}

$conn->close();
?>
