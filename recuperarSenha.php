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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emailResponsavel'])) {
    $emailResponsavel = $_POST['emailResponsavel'];

    // Consulta para buscar o usuário com o e-mail fornecido
    $sql = "SELECT * FROM tb_responsavel WHERE emailResponsavel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emailResponsavel);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se um usuário foi encontrado
    if ($result->num_rows > 0) {
        // Recupera os dados do usuário
        $user = $result->fetch_assoc();
        $senha = $user['pswResponsavel']; // Supondo que a senha está armazenada na coluna 'pswResponsavel'

        // Envia a senha para o e-mail do usuário
        $to = $emailResponsavel;
        $subject = "Recuperação de Senha";
        $message = "Sua senha é: " . $senha;
        $headers = "From: tcc.etece24@gmail.com"; // Altere para um endereço de e-mail válido

        // Tenta enviar o e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "A senha foi enviada para o seu e-mail.";
        } else {
            echo "Erro ao enviar o e-mail.";
        }
    } else {
        echo "E-mail não encontrado.";
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
  <link rel="stylesheet" href="css/main.css">
  <script src="js/bootstrap.bundle.min.js"></script>
  <title>Recuperar Senha</title>
</head>
<body>
  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="#" style="color: aliceblue;">
      <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="Logo da empresa">
      Recording lifes
    </a>
  </nav>

  <div class="container mt-3">
    <h3>Recuperar Senha</h3>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="emailResponsavel" class="form-label">Insira seu e-mail:</label>
        <input type="email" class="form-control" id="emailResponsavel" name="emailResponsavel" required>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
</body>
</html>
