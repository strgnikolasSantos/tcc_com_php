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

// Recupera o codResponsavel da sessão
$codResponsavel = $_SESSION['codResponsavel'];

// Busca os dependentes cadastrados para o responsável logado
$sql = "SELECT codDependente, nomeDependente FROM tb_dependente WHERE codResponsavel = ?";
$stmt = $conn->prepare($sql); // Prepara a consulta
$stmt->bind_param("i", $codResponsavel); // Liga o código do responsável ao parâmetro da consulta
$stmt->execute(); // Executa a consulta
$result = $stmt->get_result(); // Obtém o resultado da consulta
$dependentes = []; // Array para armazenar os dependentes

// Armazena os dependentes encontrados em um array
while ($row = $result->fetch_assoc()) {
    $dependentes[] = $row; // Adiciona cada dependente ao array
}

// Fecha a declaração e a conexão
$stmt->close(); // Fecha a declaração
$conn->close(); // Fecha a conexão com o banco de dados

// Verifica se um dependente foi selecionado para redirecionar ou excluir
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o código do dependente foi enviado
    if (isset($_POST['codDependente'])) {
        $codDependente = intval($_POST['codDependente']); // Converte o código para inteiro
        $_SESSION['codDependente'] = $codDependente; // Armazena o código na sessão

        // Verifica se a ação é de excluir
        if (isset($_POST['action']) && $_POST['action'] === 'excluir') {
            // Redireciona para a página de exclusão do dependente
            header("Location: excluirDependente.php?codDependente=" . urlencode($codDependente));
            exit(); // Importante para evitar execução adicional
        } else {
            // Redireciona para a página de alteração do dependente
            header("Location: AlterCadDependente.php?codDependente=" . urlencode($codDependente));
            exit(); // Importante para evitar execução adicional
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gerenciar Dependentes</title>
    <meta charset="utf-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Configura o viewport para dispositivos móveis -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> <!-- Inclui o CSS do Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script> <!-- Inclui o JavaScript do Bootstrap -->
    <link href="css/style.css" rel="stylesheet"> <!-- Inclui o CSS personalizado -->
</head>
<body>
    <!-- Navegação do site -->
    <nav class="navbar navbar-light bg-dark">
        <a class="navbar-brand" href="home.php" style="color: aliceblue;">
            <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="">
            Recording Lifes
        </a>
    </nav>

    <div class="container-fluid mt-3"> <!-- Contêiner para o conteúdo principal -->
        <div class="row">
            <div class="col-sm-12 p-4">
                <h3 class="name">Gerenciar Dependentes</h3> <!-- Título da página -->
            </div>
            <div class="col-sm-3 p-2"></div> <!-- Coluna vazia para espaçamento -->
            <div class="col-sm-6 p-2 bg-dark text-white"> <!-- Coluna principal com fundo escuro -->
                <form id="formGerenciar" class="row g-3" method="POST" action=""> <!-- Formulário para gerenciar dependentes -->
                    <div class="col-md-12">
                        <label for="dependenteSelect" class="form-label">Selecione um Dependente</label>
                        <select id="dependenteSelect" name="codDependente" class="form-select" required>
                            <option value="" disabled selected>Escolha um dependente</option> <!-- Opção padrão -->
                            <?php foreach ($dependentes as $dependente): ?> <!-- Loop para gerar opções de dependentes -->
                                <option value="<?php echo htmlspecialchars($dependente['codDependente']); ?>">
                                    <?php echo htmlspecialchars($dependente['nomeDependente']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <!-- Botões para alterar ou excluir dependente -->
                        <button type="submit" class="btn btn-primary">Alterar</button>
                        <button type="submit" name="action" value="excluir" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-3 p-2"></div> <!-- Coluna vazia para espaçamento -->
        </div>
    </div>
</body>
</html>
