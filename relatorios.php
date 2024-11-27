<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Relatório de vitórias, empates e derrotas por equipe
$sql_resultados = "
    SELECT e.nome_equipe, 
           SUM(CASE WHEN r.gols_equipe_casa > r.gols_equipe_fora THEN 1 ELSE 0 END) AS vitorias,
           SUM(CASE WHEN r.gols_equipe_casa = r.gols_equipe_fora THEN 1 ELSE 0 END) AS empates,
           SUM(CASE WHEN r.gols_equipe_casa < r.gols_equipe_fora THEN 1 ELSE 0 END) AS derrotas
    FROM equipes e
    LEFT JOIN partidas p ON p.id_equipe_casa = e.id OR p.id_equipe_fora = e.id
    LEFT JOIN resultados r ON r.id_partida = p.id
    GROUP BY e.id, e.nome_equipe
";
$resultados_teams = $link->query($sql_resultados);

// Ranking de artilheiros
$sql_artilheiros = "
    SELECT j.nome, COUNT(g.id) AS total_gols
    FROM jogadores j
    LEFT JOIN gols g ON g.id_jogador = j.id
    GROUP BY j.id
    ORDER BY total_gols DESC
";
$artilheiros_result = $link->query($sql_artilheiros);

// Total de gols por equipe
$sql_gols_equipe = "
    SELECT e.nome_equipe, SUM(r.gols_equipe_casa) AS gols_marcados
    FROM equipes e
    LEFT JOIN partidas p ON p.id_equipe_casa = e.id OR p.id_equipe_fora = e.id
    LEFT JOIN resultados r ON r.id_partida = p.id
    GROUP BY e.id, e.nome_equipe
";
$gols_equipe_result = $link->query($sql_gols_equipe);
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

        .container-table {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #2FB659;
            color: white;
        }

        h5 {
            color: #2FB659;
            margin-top: 20px;
        }
    </style>
    <title>Relatórios Detalhados</title>
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
                    <a class="nav-link" href="pagina_principal_administrador.php">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Relatórios Detalhados -->
    <div class="container-table">
        <h3 class="text-center mb-4">Relatórios Detalhados</h3>

        <!-- Relatório de Vitórias, Empates e Derrotas -->
        <h5>Vitórias, Empates e Derrotas por Equipe</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Equipe</th>
                    <th scope="col">Vitórias</th>
                    <th scope="col">Empates</th>
                    <th scope="col">Derrotas</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultados_teams->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome_equipe']); ?></td>
                        <td><?= htmlspecialchars($row['vitorias']); ?></td>
                        <td><?= htmlspecialchars($row['empates']); ?></td>
                        <td><?= htmlspecialchars($row['derrotas']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Ranking de Artilheiros -->
        <h5>Ranking de Artilheiros</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Jogador</th>
                    <th scope="col">Total de Gols</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $artilheiros_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome']); ?></td>
                        <td><?= htmlspecialchars($row['total_gols']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Total de Gols por Equipe -->
        <h5>Total de Gols por Equipe</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Equipe</th>
                    <th scope="col">Gols Marcados</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $gols_equipe_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome_equipe']); ?></td>
                        <td><?= htmlspecialchars($row['gols_marcados']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/js/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
