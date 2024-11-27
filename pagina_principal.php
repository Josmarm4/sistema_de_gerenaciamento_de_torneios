<?php
session_start();
include 'conexaoBD.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona caso o usuário não esteja logado
    exit;
}

// Obter o nome do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT nome FROM usuarios WHERE id = ?";
$stmt_usuario = $link->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$stmt_usuario->bind_result($nome_usuario);
$stmt_usuario->fetch();
$stmt_usuario->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('img/img01.webp'); /* Caminho para a imagem */
            background-size: cover;  /* A imagem cobre toda a tela */
            background-position: center center;  /* Centraliza a imagem */
            background-attachment: fixed;  /* Fixar a imagem ao fundo */
            padding-top: 60px; /* Ajusta o espaço para o topo da página */
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

        .container {
            max-width: 900px;
            margin-top: 80px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #2FB659;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #2FB659;
            color: white;
            border: none;
            font-size: 18px;
            margin: 10px 0;
        }

        .btn-custom:hover {
            background-color: #279149;
            color: white !important;
            border-color: #279149;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .btn-container .btn {
            width: 250px;
        }

        .card {
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 20px;
            color: #2FB659;
        }

        .card-text {
            font-size: 16px;
        }
    </style>
    <title>Página Inicial</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="pagina_principal.php">IFPR - Esportes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="perfil_usuario.php">Meu Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="torneios_disponiveis.php">Torneios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historico_inscricoes.php">Histórico de Inscrições</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notificacoes.php">Notificações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classificacao_torneio.php?id=1">Classificação</a> <!-- ID do torneio pode ser dinâmico -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h3>Bem-vindo, <?= htmlspecialchars($nome_usuario); ?>!</h3>
        <p>Aqui você pode acessar várias funcionalidades do sistema, para gerenciar sua participação nos torneios e manter-se atualizado.</p>

        <!-- Botões de Ação -->
        <div class="btn-container">
            <a href="perfil_usuario.php" class="btn btn-custom btn-lg">Ver Meu Perfil</a>
            <a href="historico_inscricoes.php" class="btn btn-custom btn-lg">Meu Histórico de Inscrições</a>
            <a href="notificacoes.php" class="btn btn-custom btn-lg">Ver Notificações</a>
            <a href="classificacao_torneio.php?id=1" class="btn btn-custom btn-lg">Ver Classificação</a>
        </div>

        <!-- Card com Informações Adicionais -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">O que mais você pode fazer?</h5>
                <p class="card-text">Explore os torneios disponíveis, inscreva-se para participar e acompanhe os resultados e a classificação de sua equipe.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
