<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_equipe = $_POST['nome_equipe'];
    $treinador = $_POST['treinador'];
    $contato = $_POST['contato'];

    $sql = "INSERT INTO equipes (nome_equipe, treinador, contato) VALUES ('$nome_equipe', '$treinador', '$contato')";
    if ($link->query($sql) === TRUE) {
        $mensagem = "Equipe cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar equipe: " . $link->error;
    }
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }
        .navbar-custom {
            background-color: #2FB659;
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }
        .navbar-custom .nav-link:hover {
            color: #d4d4d4;
        }
        .container-form {
            display: flex;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
            margin: 20px auto;
        }
        .left-panel {
            background-color: #2FB659;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 40%;
        }
        .right-panel {
            padding: 40px;
            width: 60%;
        }
        .btn-custom {
            background-color: #2FB659;
            border-color: #2FB659;
            color: white;
        }
        .btn-custom:hover {
            background-color: #279149;
            border-color: #279149;
        }
    </style>
    <title>Cadastro de Equipes</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <a class="navbar-brand" href="index.php">IFPR - Esportes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastro_equipes.php">Cadastro de Equipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscricao_torneio.php">Inscrição em Torneios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="criar_torneio.php">Criação de Torneios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="resultados_jogos.php">Resultados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classificacao.php">Classificação</a>
                </li>
            </ul>
    </div>
    </nav>

    <!-- Formulário de Cadastro -->
    <div class="container-form mt-5">
        <div class="left-panel text-center">
            <h2>Gerencie Suas Equipes</h2>
            <p>Adicione novas equipes ao sistema.</p>
        </div>

        <div class="right-panel">
            <h3>Cadastro de Equipes</h3>
            <?php if (isset($mensagem)) { ?>
                <div class="alert alert-info text-center" role="alert">
                    <?= $mensagem; ?>
                </div>
            <?php } ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome_equipe">Nome da Equipe</label>
                    <input type="text" class="form-control" id="nome_equipe" name="nome_equipe" required>
                </div>
                <div class="form-group">
                    <label for="treinador">Treinador</label>
                    <input type="text" class="form-control" id="treinador" name="treinador" required>
                </div>
                <div class="form-group">
                    <label for="contato">Contato</label>
                    <input type="text" class="form-control" id="contato" name="contato" required>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Cadastrar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
