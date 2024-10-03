<?php
// Configurações do banco de dados
$servername = "sql212.infinityfree.com";
$username = "if0_37379490";
$password = "F6rcghopPPm1puw ";
$dbname = "if0_37379490_tcc_db";

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber os dados JSON da requisição
$data = file_get_contents("php://input");
$json = json_decode($data, true);

// Verificar se a decodificação foi bem-sucedida e se o código do responsável foi fornecido
if (json_last_error() === JSON_ERROR_NONE && isset($json['codResponsavel'])) {
    $codResponsavel = $json['codResponsavel'];

    // Preparar a consulta para excluir o responsável
    $stmt = $conn->prepare("DELETE FROM tb_responsavel WHERE codResponsavel = ?");
    $stmt->bind_param("i", $codResponsavel);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Responsável excluído com sucesso.";
    } else {
        echo "Erro ao excluir responsável: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
} else {
    echo "Dados inválidos ou ausentes.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
