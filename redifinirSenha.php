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

// Verifica se o token foi fornecido
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token é válido
    $sql = "SELECT * FROM tb_responsavel WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o token for válido, mostra o formulário de redefinição de senha
    if ($result->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $novaSenha = $_POST['novaSenha'];
            $confirmarSenha = $_POST['confirmarSenha'];

            // Verifica se as senhas correspondem
            if ($novaSenha === $confirmarSenha) {
                // Aqui você deve fazer a lógica para atualizar a senha (use hash para segurança)
                $hashedSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
                $update_sql = "UPDATE tb_responsavel SET pswResponsavel = ?, token = NULL WHERE token = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $hashedSenha, $token);
                
                if ($update_stmt->execute()) {
                    echo "Senha redefinida com sucesso! Você pode fazer login agora.";
                    // Você pode redirecionar para a página de login
                    // header("Location: login.php");
                } else {
                    echo "Erro ao redefinir a senha. Tente novamente.";
                }
            } else {
                echo "As senhas não correspondem. Tente novamente.";
            }
        }
    } else {
        echo "Token inválido ou expirado.";
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
  <title>Redefinir Senha</title>
</head>
<body>
  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="#" style="color: aliceblue;">
      <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="Logo da empresa">
      Recording lifes
    </a>
  </nav>

  <div class="container mt-3">
    <h3>Redefinir Senha</h3>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="novaSenha" class="form-label">Nova Senha:</label>
        <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
      </div>
      <div class="mb-3">
        <label for="confirmarSenha" class="form-label">Confirmar Nova Senha:</label>
        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
      </div>
      <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
  </div>
</body>
</html>
