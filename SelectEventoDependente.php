<?php
// Inicia a sessão para acessar variáveis de sessão
session_start();

// Ativa a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o codResponsavel está definido na sessão
$codResponsavel = isset($_SESSION['codResponsavel']) ? $_SESSION['codResponsavel'] : null;

if (!$codResponsavel) {
    die("Erro: Responsável não está logado.");
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

// Inicializa uma variável para os dependentes
$dependentes = [];

// Consulta para buscar os dependentes do responsável logado
$sql = "SELECT codDependente, nomeDependente FROM tb_dependente WHERE codResponsavel = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $codResponsavel);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados e os armazena em um array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dependentes[] = $row;
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
  <title>Selecionar Dependente</title>
</head>
<body>
  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="home.php" style="color: aliceblue;">
      <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="Logo da empresa">
      Recording lifes
    </a>
  </nav>

  <div class="container mt-3">
    <h3>Selecionar Dependente</h3>
    <form action="visualizarEventos.php" method="GET">
      <div class="mb-3">
        <label for="dependente" class="form-label">Escolha um dependente:</label>
        <select class="form-control" id="dependente" name="idDependente" required>
          <option value="">Selecione um dependente</option>
          <?php foreach ($dependentes as $dependente): ?>
            <option value="<?php echo $dependente['codDependente']; ?>"><?php echo $dependente['nomeDependente']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Visualizar Eventos</button>
    </form>
  </div>
</body>
</html>
