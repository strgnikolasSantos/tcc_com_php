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

// Captura o código do dependente da URL
$codDependente = isset($_GET['codDependente']) ? $_GET['codDependente'] : ''; // Verifica se o código foi passado na URL

// Inicializa variáveis para armazenar os dados do dependente
$nomeDependente = $nascDependente = $descRelacao = $generoDependente = $condSaude = '';

// Se um código de dependente foi fornecido, busca os dados do dependente
if ($codDependente) {
    // Prepara a consulta para buscar os dados do dependente
    $sql = "SELECT nomeDependente, nascDependente, descRelacao, generoDependente, condSaude FROM tb_dependente WHERE codDependente = ?";
    $stmt = $conn->prepare($sql); // Prepara a consulta
    $stmt->bind_param("i", $codDependente); // Liga o código do dependente ao parâmetro da consulta
    $stmt->execute(); // Executa a consulta
    $stmt->bind_result($nomeDependente, $nascDependente, $descRelacao, $generoDependente, $condSaude); // Liga os resultados às variáveis
    $stmt->fetch(); // Busca os resultados da consulta
    $stmt->close(); // Fecha a declaração
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alterar Dependente</title>
    <meta charset="utf-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Configura o viewport para dispositivos móveis -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> <!-- Inclui o CSS do Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script> <!-- Inclui o JavaScript do Bootstrap -->
    <link href="css/style.css" rel="stylesheet"> <!-- Inclui o CSS personalizado -->
</head>
<body>
    <!-- Navegação do site -->
    <nav class="navbar navbar-light bg-dark">
        <a class="navbar-brand" href="login.html" style="color: aliceblue;">
            <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="">
            Recording Lifes
        </a>
    </nav>

    <div class="container-fluid mt-3"> <!-- Contêiner para o conteúdo principal -->
        <div class="row">
            <div class="col-sm-12 p-4">
                <h3 class="name">Alterar Dependente</h3> <!-- Título da página -->
            </div>
            <div class="col-sm-3 p-2"></div> <!-- Coluna vazia para espaçamento -->
            <div class="col-sm-6 p-2 bg-dark text-white"> <!-- Coluna principal com fundo escuro -->
                <form id="formAlterar" class="row g-3" action="altDependente.php" method="POST">
                    <!-- Campo oculto para armazenar o código do dependente -->
                    <input type="hidden" class="form-control" id="codDependente" name="codDependente" value="<?php echo htmlspecialchars($codDependente); ?>">

                    <div class="col-md-6">
                        <label for="nomeDependente" class="form-label">Nome do Dependente</label>
                        <input type="text" class="form-control" id="nomeDependente" name="nomeDependente" value="<?php echo htmlspecialchars($nomeDependente); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="nascDependente" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="nascDependente" name="nascDependente" value="<?php echo htmlspecialchars($nascDependente); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="descRelacao" class="form-label">Grau Familiar</label>
                        <select id="descRelacao" class="form-select" name="descRelacao" required>
                            <option value="Pai" <?php if ($descRelacao == "Pai") echo 'selected'; ?>>Pai</option>
                            <option value="Mãe" <?php if ($descRelacao == "Mãe") echo 'selected'; ?>>Mãe</option>
                            <option value="Filho" <?php if ($descRelacao == "Filho") echo 'selected'; ?>>Filho</option>
                            <option value="Filha" <?php if ($descRelacao == "Filha") echo 'selected'; ?>>Filha</option>
                            <option value="Irmão" <?php if ($descRelacao == "Irmão") echo 'selected'; ?>>Irmão</option>
                            <option value="Irmã" <?php if ($descRelacao == "Irmã") echo 'selected'; ?>>Irmã</option>
                            <option value="Outro" <?php if ($descRelacao == "Outro") echo 'selected'; ?>>Outro</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="generoDependente" class="form-label">Gênero</label>
                        <select id="generoDependente" class="form-select" name="generoDependente" required>
                            <option value="Masculino" <?php if ($generoDependente == "Masculino") echo 'selected'; ?>>Masculino</option>
                            <option value="Feminino" <?php if ($generoDependente == "Feminino") echo 'selected'; ?>>Feminino</option>
                            <option value="Outro" <?php if ($generoDependente == "Outro") echo 'selected'; ?>>Outro</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="condSaude" class="form-label">Condições de Saúde</label>
                        <textarea class="form-control" id="condSaude" name="condSaude" required rows="3"><?php echo htmlspecialchars($condSaude); ?></textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="depGridCheck" required>
                            <label class="form-check-label" for="depGridCheck">Concordo com os termos</label><br><br>
                            <button type="submit" class="btn btn-primary">Alterar</button> <!-- Botão para enviar o formulário -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3 p-2"></div> <!-- Coluna vazia para espaçamento -->
        </div>
    </div>
</body>
</html>
