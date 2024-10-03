<?php
// Ativa a exibição de erros para depuração
ini_set('display_errors', 1); // Habilita a exibição de erros
ini_set('display_startup_errors', 1); // Habilita a exibição de erros durante a inicialização
error_reporting(E_ALL); // Define o nível de relatórios para todos os tipos de erros

// Inicia a sessão
session_start(); // Começa uma nova sessão ou retoma a sessão existente

// Verifica se o usuário está logado
if (!isset($_SESSION['codResponsavel'])) {
    // Se o usuário não estiver logado, interrompe a execução e exibe uma mensagem
    die("Acesso negado. Você precisa estar logado.");
}

// Configurações do banco de dados
$servername = "sql212.infinityfree.com"; // Nome do servidor do banco de dados
$username = "if0_37379490"; // Nome de usuário do banco de dados
$password = "F6rcghopPPm1puw"; // Senha do banco de dados
$dbname = "if0_37379490_tcc_db"; // Nome do banco de dados

// Criação da conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se houver erro na conexão, interrompe a execução e exibe uma mensagem
    die("Conexão falhou: " . $conn->connect_error);
}

// Recupera os dados do responsável logado
$codResponsavel = $_SESSION['codResponsavel']; // Captura o código do responsável da sessão
$stmt = $conn->prepare("SELECT nomeResponsavel, nasciResponsavel, emailResponsavel, generoResponsavel FROM tb_responsavel WHERE codResponsavel = ?");
$stmt->bind_param("i", $codResponsavel); // Liga o código do responsável ao parâmetro da consulta
$stmt->execute(); // Executa a consulta
$stmt->bind_result($nome, $data_nascimento, $email, $genero); // Liga os resultados às variáveis
$stmt->fetch(); // Busca os dados
$stmt->close(); // Fecha a declaração

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Responsável</title> <!-- Título da página -->
    <meta charset="utf-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Configura o viewport para dispositivos móveis -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> <!-- Inclui o CSS do Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script> <!-- Inclui o JavaScript do Bootstrap -->
    <link href="css/style.css" rel="stylesheet"> <!-- Inclui o CSS personalizado -->
</head>

<body class="bg-dark text-light"> <!-- Define classes para fundo escuro e texto claro -->
    <nav class="navbar navbar-light bg-dark"> <!-- Barra de navegação -->
        <a class="navbar-brand" href="home.php" style="color: aliceblue;">
            Recording Lifes
        </a>
    </nav>

    <div class="container mt-5"> <!-- Contêiner para o conteúdo principal -->
        <div class="row justify-content-center"> <!-- Linha centralizada -->
            <div class="col-md-6"> <!-- Coluna de tamanho médio -->
                <div class="card bg-dark text-light p-4"> <!-- Cartão com fundo escuro -->
                    <h3 class="card-title">Editar Responsável</h3> <!-- Título do formulário -->
                    <form id="responsavelForm" method="POST" action="altResponsavel.php"> <!-- Formulário para editar dados do responsável -->
                        <div class="mb-3"> <!-- Campo para Nome -->
                            <label for="nomeResponsavel" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeResponsavel" name="nomeResponsavel" value="<?php echo htmlspecialchars($nome); ?>" required>
                        </div>
                        <div class="mb-3"> <!-- Campo para Data de Nascimento -->
                            <label for="nasciResponsavel" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="nasciResponsavel" name="nasciResponsavel" value="<?php echo htmlspecialchars($data_nascimento); ?>" required>
                        </div>
                        <div class="mb-3"> <!-- Campo para E-mail -->
                            <label for="emailResponsavel" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="emailResponsavel" name="emailResponsavel" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-3"> <!-- Campo para Gênero -->
                            <label for="generoResponsavel" class="form-label">Gênero</label>
                            <select id="generoResponsavel" name="generoResponsavel" class="form-select" required>
                                <option value="Masculino" <?php echo ($genero == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Feminino" <?php echo ($genero == 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                                <option value="Outro" <?php echo ($genero == 'Outro') ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button> <!-- Botão para enviar o formulário -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
