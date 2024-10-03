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

// Verifica se o idDependente foi passado pela URL
$idDependente = isset($_GET['idDependente']) ? $_GET['idDependente'] : null;

if ($idDependente === null) {
    die("Erro: Nenhum dependente selecionado.");
}

// Inicializa um array para os eventos
$eventos = [];

// Consulta para buscar os eventos do dependente selecionado
$sql = "SELECT * FROM tb_eventos WHERE codDependente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idDependente);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados e os armazena em um array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <title>Visualizar Eventos</title>
</head>
<body>
  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="#" style="color: aliceblue;">
      <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="Logo da empresa">
      Recording lifes
    </a>
  </nav>

  <div class="container mt-3">
    <h3>Eventos do Dependente</h3>
    <table class="table">
      <thead>
        <tr>
          <th>Código do Evento</th>
          <th>Descrição do Evento</th>
          <th>Data e Hora</th> <!-- Adicione mais campos conforme necessário -->
        </tr>
      </thead>
      <tbody>
        <?php if (count($eventos) > 0): ?>
          <?php foreach ($eventos as $evento): ?>
            <tr>
              <td><?php echo htmlspecialchars($evento['codEvento']); ?></td>
              <td><?php echo htmlspecialchars($evento['descEvento']); ?></td>
              <td><?php echo htmlspecialchars($evento['dataHoraEvento']); ?></td> <!-- Ajuste para o campo de data e hora -->
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="text-center">Nenhum evento cadastrado para este dependente.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
