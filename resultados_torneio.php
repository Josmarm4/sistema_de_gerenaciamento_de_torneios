<?php
session_start();
include 'conexaoBD.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado e é um usuário comum
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] == 'admin') {
    header("Location: login.php"); // Redireciona caso o usuário não esteja logado ou seja admin
    exit;
}

// Verifica se o ID do torneio foi passado
if (isset($_GET['id'])) {
    $id_torneio = $_GET['id'];

    // Obter o nome do torneio
    $sql_torneio = "SELECT nome_torneio FROM torneios WHERE id = ?";
    $stmt_torneio = $link->prepare($sql_torneio);
    $stmt_torneio->bind_param("i", $id_torneio);
    $stmt_torneio->execute();
    $stmt_torneio->bind_result($nome_torneio);
    $stmt_torneio->fetch();
    $stmt_torneio->close();

    // Obter os resultados das partidas
    $sql_resultados = "
        SELECT e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, r.gols_equipe_casa, r.gols_equipe_fora, p.data_partida
        FROM resultados r
        JOIN partidas p ON r.id_partida = p.id
        JOIN equipes e1 ON p.id_equipe_casa = e1.id
        JOIN equipes e2 ON p.id_equipe_fora = e2.id
        WHERE p.id_torneio = ?
        ORDER BY p.data_partida DESC";
    $stmt_resultados = $link->prepare($sql_resultados);
    $stmt_resultados->bind_param("i", $id_torneio);
    $stmt_resultados->execute();
    $resultados = $stmt_resultados->get_result();

    // Obter a classificação das equipes
    $sql_classificacao = "
        SELECT e.nome_equipe, 
               SUM(CASE WHEN r.gols_equipe_casa > r.gols_equipe_fora THEN 3
                        WHEN r.gols_equipe_casa = r.gols_equipe_fora THEN 1
                        ELSE 0 END) AS pontos
        FROM equipes e
        LEFT JOIN partidas p ON p.id_equipe_casa = e.id OR p.id_equipe_fora = e.id
        LEFT JOIN resultados r ON r.id_partida = p.id
        WHERE p.id_torneio = ?
        GROUP BY e.id
        ORDER BY pontos DESC";
    $stmt_classificacao = $link->prepare($sql_classificacao);
    $stmt_classificacao->bind_param("i", $id_torneio);
    $stmt_classificacao->execute();
    $classificacao = $stmt_classificacao->get_result();

} else {
    // Redireciona se o ID do torneio não for encontrado
    header("Location: torneios_disponiveis.php");
    exit;
}
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
    </style>
    <title>Resultados - <?= htmlspecialchars($nome_torneio); ?></title>
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
        <h3>Resultados - <?= htmlspecialchars($nome_torneio); ?></h3>

        <!-- Resultados das Partidas -->
        <h5>Resultados das Partidas</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Equipe Casa</th>
                    <th scope="col">Equipe Fora</th>
                    <th scope="col">Gols Casa</th>
                    <th scope="col">Gols Fora</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultados->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['equipe_casa']); ?></td>
                        <td><?= htmlspecialchars($row['equipe_fora']); ?></td>
                        <td><?= htmlspecialchars($row['gols_equipe_casa']); ?></td>
                        <td><?= htmlspecialchars($row['gols_equipe_fora']); ?></td>
                        <td><?= htmlspecialchars($row['data_partida']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Classificação das Equipes -->
        <h5>Classificação Atual</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Posição</th>
                    <th scope="col">Equipe</th>
                    <th scope="col">Pontos</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $posicao = 1;
                while ($row = $classificacao->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $posicao++; ?></td>
                        <td><?= htmlspecialchars($row['nome_equipe']); ?></td>
                        <td><?= htmlspecialchars($row['pontos']); ?></td>
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
