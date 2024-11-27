<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona para o login caso o usuário não esteja autenticado
    exit;
}

// Obter informações do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome FROM usuarios WHERE id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $usuario_nome = $usuario['nome'];
} else {
    $usuario_nome = "Usuário desconhecido";
}

$stmt->close();
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
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #28a745; /* Verde suave */
            border-color: #28a745;     /* Cor de borda ajustada */
            color: white;              /* Cor do texto permanece branca */
        }

        .btn-custom:hover, 
        .btn-custom:focus {
            background-color: #218838; /* Verde escuro para o hover */
            border-color: #1e7e34;     /* Cor de borda escura para o hover */
            color: white !important;   /* Garante que a cor do texto permaneça branca */
            text-decoration: none;     /* Remove qualquer sublinhado, se houver */
        }

        .btn-custom:active {
            background-color: #1e7e34; /* Tom escuro quando pressionado */
            border-color: #1c7430;     /* Cor de borda mais escura no estado ativo */
        }

    </style>
    <title>Página Principal</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="pagina_principal_administrador.php">IFPR - Esportes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="painel_administrador.php">Painel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="resultados_jogos.php">Resultados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Bem-vindo, <?= $usuario_nome ?>!</h1>
            <p class="lead">Aqui você pode gerenciar torneios, visualizar resultados e muito mais.</p>
            <hr class="my-4">
            <p>Escolha uma das opções acima para começar.</p>
            <a class="btn btn-custom btn-lg" href="painel_administrador.php" role="button">Acessar Painel de Administração</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
