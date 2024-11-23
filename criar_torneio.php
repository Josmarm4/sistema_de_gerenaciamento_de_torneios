<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_torneio = $_POST['nome_torneio'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $local = $_POST['local'];
    $regras = $_POST['regras'];

    $sql = "INSERT INTO torneios (nome_torneio, descricao, data_inicio, data_fim, local, regras) 
            VALUES ('$nome_torneio', '$descricao', '$data_inicio', '$data_fim', '$local', '$regras')";
    
    if ($link->query($sql) === TRUE) {
        $mensagem = "Torneio criado com sucesso!";
    } else {
        $mensagem = "Erro ao criar torneio: " . $link->error;
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
    <title>Criação de Torneio</title>
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

    <!-- Formulário de Criação de Torneio -->
    <div class="container-form mt-5">
        <div class="left-panel text-center">
            <h2>Criar Novo Torneio</h2>
            <p>Cadastre os detalhes de um novo torneio.</p>
        </div>

        <div class="right-panel">
            <h3>Criação de Torneio</h3>
            <?php if (isset($mensagem)) { ?>
                <div class="alert alert-info text-center" role="alert">
                    <?= $mensagem; ?>
                </div>
            <?php } ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome_torneio">Nome do Torneio</label>
                    <input type="text" class="form-control" id="nome_torneio" name="nome_torneio" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="data_inicio">Data de Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                </div>
                <div class="form-group">
                    <label for="data_fim">Data de Término</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                </div>
                <div class="form-group">
                    <label for="local">Local</label>
                    <input type="text" class="form-control" id="local" name="local">
                </div>
                <div class="form-group">
                    <label for="regras">Regras</label>
                    <textarea class="form-control" id="regras" name="regras" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Criar Torneio</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>