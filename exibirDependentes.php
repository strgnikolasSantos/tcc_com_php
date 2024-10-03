<?php
header('Content-Type: application/json');

// Parâmetros de conexão com o banco de dados
$servername = "sql212.infinityfree.com";
$username = "if0_37379490";
$password = "F6rcghopPPm1puw ";
$dbname = "if0_37379490_tcc_db";
// Criar conexão

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(array('error' => 'Falha na conexão com o banco de dados')));
}

// Obter o parâmetro codDependente da requisição POST
$codDependente = isset($_POST['codDependente']) ? $_POST['codDependente'] : '';

if (empty($codDependente)) {
    echo json_encode(array('error' => 'Código do dependente não fornecido'));
    $conn->close();
    exit();
}

// Preparar a consulta SQL
$sql = "SELECT * FROM dependentes WHERE codDependente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codDependente);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se algum registro foi encontrado
if ($result->num_rows > 0) {
    $dados = array();
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
    echo json_encode($dados);
} else {
    echo json_encode(array('error' => 'Dependente não encontrado'));
}

// Fechar conexão
$stmt->close();
$conn->close();
?>
