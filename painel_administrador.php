<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';
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
        .dashboard {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dashboard h3 {
            color: #2FB659;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-dashboard {
            background-color: #2FB659;
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-dashboard:hover {
            background-color: #279149;
            color: white;
            text-decoration: none;
        }
    </style>
    <title>Painel do Administrador</title>
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
            </ul>
    </div>
    </nav>

    <div class="dashboard">
        <h3>Painel do Administrador</h3>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <a href="cadastro_equipes.php" class="btn-dashboard d-block">Gerenciar Equipes</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="inscricao_torneio.php" class="btn-dashboard d-block">Gerenciar Inscrições</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="criar_torneio.php" class="btn-dashboard d-block">Criar Torneio</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="tabela_jogos.php" class="btn-dashboard d-block">Tabela de Jogos</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="resultados_jogos.php" class="btn-dashboard d-block">Resultados</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="classificacao.php" class="btn-dashboard d-block">Classificação</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="definir_regras.php" class="btn-dashboard d-block">Definir Regras</a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="relatorios.php" class="btn-dashboard d-block">Relatórios</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
