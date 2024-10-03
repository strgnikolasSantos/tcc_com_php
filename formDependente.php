<?php
// Captura o código do responsável da URL
$codResponsavel = isset($_GET['codResponsavel']) ? $_GET['codResponsavel'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Cadastro de Dependente</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
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
                <h3 class="name">Cadastro de Dependente</h3>
            </div>
            <div class="col-sm-3 p-2"></div>
            <div class="col-sm-6 p-2 bg-dark text-white">
                <form id="formCadastro" class="row g-3" action="cadDependente.php" method="POST">
                    <input type="hidden" class="form-control" id="codResponsavel" name="codResponsavel" value="<?php echo htmlspecialchars($codResponsavel); ?>">

                    <div class="col-md-6">
                        <label for="nomeDependente" class="form-label">Nome do Dependente</label>
                        <input type="text" class="form-control" id="nomeDependente" name="nomeDependente" placeholder="Digite o nome" required>
                    </div>

                    <div class="col-md-6">
                        <label for="nascDependente" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="nascDependente" name="nascDependente" required>
                    </div>

                    <div class="col-md-6">
                        <label for="descRelacao" class="form-label">Grau Familiar</label>
                        <select id="descRelacao" class="form-select" name="descRelacao" required>
                            <option value="" selected>Selecione</option>
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
                            <option value="" selected>Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="condSaude" class="form-label">Condições de Saúde</label>
                        <textarea class="form-control" id="condSaude" name="condSaude" required rows="3" placeholder="Descreva quaisquer condições de saúde relevantes"></textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="depGridCheck" required>
                            <label class="form-check-label" for="depGridCheck">Concordo com os termos</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-3 p-2"></div>
        </div>
    </div>
</body>
</html>
