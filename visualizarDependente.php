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

// Inicializa o código do dependente
$codDependente = null;

// Verifica se o codDependente foi enviado
if (isset($_GET['idDependente'])) {
    $codDependente = $_GET['idDependente'];

    // Inserir na tabela tb_eventos
    $descricaoEvento = "Iniciou a transmissão";
    $sql = "INSERT INTO tb_eventos (descEvento, codDependente) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descricaoEvento, $codDependente);
    
    if ($stmt->execute()) {
        echo "Evento registrado com sucesso: " . $descricaoEvento . "<br>";
    } else {
        echo "Erro ao registrar o evento: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
} else {
    echo "Dependente não especificado.";
}

// Verifica se o formulário de finalização foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_transmissao'])) {
    // Inserir na tabela tb_eventos
    $descricaoEvento = "Transmissão finalizada.";
    $sql = "INSERT INTO tb_eventos (descEvento, codDependente) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descricaoEvento, $codDependente);
    
    if ($stmt->execute()) {
        // Redireciona para home.php
        header("Location: home.php");
        exit();
    } else {
        echo "Erro ao registrar o evento: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <title>Visualizar Dependente</title>
  <style>
      .video-container {
          display: flex;
          justify-content: center;
          align-items: center;
          margin: 20px 0; /* Espaçamento acima e abaixo do vídeo */
      }
      iframe {
          width: 560px;  /* Largura do vídeo */
          height: 315px; /* Altura do vídeo */
      }
  </style>
</head>
<body>
  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="#" style="color: aliceblue;">
      <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="Logo da empresa">
      Recording lifes
    </a>
  </nav>

  <div class="container mt-3">
    <h3>Transmissão Iniciada</h3>
    <p><?php echo "A transmissão para o dependente foi iniciada."; ?></p>
    
    <!-- WebView para o vídeo do YouTube -->
    <div class="video-container">
        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
    </div>
    
    <!-- Formulário para finalizar a transmissão -->
    <form method="POST" action="">
      <button type="submit" name="finalizar_transmissao" class="btn btn-danger">Finalizar Transmissão</button>
    </form>
  </div>
</body>
</html>
