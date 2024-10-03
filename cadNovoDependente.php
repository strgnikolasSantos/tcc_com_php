<?php
// Configurações do banco de dados
$servername = "sql212.infinityfree.com"; // Nome do servidor do banco de dados
$username = "if0_37379490"; // Nome de usuário do banco de dados
$password = "F6rcghopPPm1puw"; // Senha do banco de dados
$dbname = "if0_37379490_tcc_db"; // Nome do banco de dados

// Criação da conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error); // Interrompe a execução e exibe a mensagem de erro
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nomeDependente = $_POST['nomeDependente']; // Nome do dependente
    $data_nascimento = $_POST['nascDependente']; // Data de nascimento do dependente
    $genero = $_POST['generoDependente']; // Gênero do dependente
    $grau_familiar = $_POST['descRelacao']; // Grau de parentesco
    $condicoes_saude = $_POST['condSaude']; // Condições de saúde do dependente
    $codResponsavel = $_POST['codResponsavel']; // Código do responsável

    // Prepara a consulta SQL para inserir os dados do dependente
    $stmt = $conn->prepare("INSERT INTO tb_dependente (nomeDependente, nascDependente, generoDependente, descRelacao, condSaude, codResponsavel) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt) {
        // Liga os parâmetros à consulta
        $stmt->bind_param("ssssss", $nomeDependente, $data_nascimento, $genero, $grau_familiar, $condicoes_saude, $codResponsavel);

        // Executa a consulta
        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, redireciona para a página home.php
            header("Location: home.php?codResponsavel=" . urlencode($codResponsavel));
            exit(); // Interrompe a execução do script após o redirecionamento
        } else {
            // Se houver um erro ao executar a inserção, exibe a mensagem de erro
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        // Se houver erro na preparação da declaração, exibe a mensagem de erro
        echo "Erro na preparação da declaração: " . $conn->error;
    }
} else {
    // Se o formulário não foi enviado, captura o código do responsável da URL
    $codResponsavel = isset($_GET['codResponsavel']) ? $_GET['codResponsavel'] : ''; // Define como vazio se não estiver presente
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cadastro de Dependente</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet"> <!-- Link para o CSS do Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script> <!-- Script para o Bootstrap -->
    <link href="css/style.css" rel="stylesheet"> <!-- Link para o CSS personalizado -->
</head>
<body>
    <nav class="navbar navbar-light bg-dark">
        <a class="navbar-brand" href="login.html" style="color: aliceblue;">
            <img src="img/logo.jfif" width="25" height="30" style="border-radius: 90px;" class="d-inline-block align-top" alt="">
            Recording Lifes
        </a>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-12 p-4">
                <h3 class="name">Cadastro Dependente</h3> <!-- Título da página -->
            </div>
            <div class="col-sm-3 p-2"></div>
            <div class="col-sm-6 p-2 bg-dark text-white">
                <form id="formCadastro" class="row g-3" action="cadNovoDependente.php" method="POST">
                    <!-- Campo oculto para armazenar o código do responsável -->
                    <input type="hidden" class="form-control" id="codResponsavel" name="codResponsavel" value="<?php echo htmlspecialchars($codResponsavel); ?>">

                    <div class="col-md-6">
                        <label for="nomeDependente" class="form-label">Nome do Dependente</label>
                        <input type="text" class="form-control" id="nomeDependente" name="nomeDependente" required> <!-- Campo para o nome do dependente -->
                    </div>

                    <div class="col-md-6">
                        <label for="nascDependente" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="nascDependente" name="nascDependente" required> <!-- Campo para a data de nascimento -->
                    </div>

                    <div class="col-md-6">
                        <label for="descRelacao" class="form-label">Grau Familiar</label>
                        <select id="descRelacao" class="form-select" name="descRelacao" required>
                            <option selected></option>
                            <option value="Pai">Pai</option>
                            <option value="Mãe">Mãe</option>
                            <option value="Filho">Filho</option>
                            <option value="Filha">Filha</option>
                            <option value="Irmão">Irmão</option>
                            <option value="Irmã">Irmã</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="generoDependente" class="form-label">Gênero</label>
                        <select id="generoDependente" class="form-select" name="generoDependente" required>
                            <option selected>Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="condSaude" class="form-label">Condições de Saúde</label>
                        <textarea class="form-control" id="condSaude" name="condSaude" required rows="3" placeholder="Descreva quaisquer condições de saúde relevantes"></textarea> <!-- Campo para condições de saúde -->
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="depGridCheck" required>
                            <label class="form-check-label" for="depGridCheck">Concordo com os termos</label><br><br>
                            <button type="submit" class="btn btn-primary">Cadastrar</button> <!-- Botão para enviar o formulário -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3 p-2"></div>
        </div>
    </div>
</body>
</html>
