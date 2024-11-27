<?php
session_start();
include 'conexaoBD.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado e é um usuário comum
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] == 'admin') {
    header("Location: login.php"); // Redireciona caso o usuário não esteja logado ou seja admin
    exit;
}

// Obter as inscrições do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql_inscricoes = "
    SELECT t.nome_torneio, t.data_inicio, t.data_fim, i.status
    FROM torneios t
    JOIN inscricoes i ON t.id = i.id_torneio
    WHERE i.id_usuario = ?
";
$stmt_inscricoes = $link->prepare($sql_inscricoes);
$stmt_inscricoes->bind_param("i", $usuario_id);
$stmt_inscricoes->execute();
$result_inscricoes = $stmt_inscricoes->get_result();
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
            margin-top: 100px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #2FB659;
            text-align: center;
        }

        .table thead {
            background-color: #2FB659;
            color: white;
        }

        .btn-custom {
            background-color: #2FB659;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #279149;
            border-color: #279149;
        }
    </style>
    <title>Histórico de Inscrições</title>
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
                    <a class="nav-link" href="pagina_principal.php">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h3>Histórico de Inscrições</h3>

        <!-- Tabela de Inscrições -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nome do Torneio</th>
                    <th scope="col">Data de Início</th>
                    <th scope="col">Data de Fim</th>
                    <th scope="col">Status da Inscrição</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_inscricoes->num_rows > 0) {
                    while ($row = $result_inscricoes->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nome_torneio']); ?></td>
                            <td><?= htmlspecialchars($row['data_inicio']); ?></td>
                            <td><?= htmlspecialchars($row['data_fim']); ?></td>
                            <td><?= htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">Você não está inscrito em nenhum torneio.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
