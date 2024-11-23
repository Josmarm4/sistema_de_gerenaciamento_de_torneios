<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';

// Consulta para obter os resultados dos jogos
$sql= "SELECT p.id, e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, r.gols_equipe_casa, r.gols_equipe_fora, p.data_partida, p.hora_partida
                   FROM resultados r
                   JOIN partidas p ON r.id_partida = p.id
                   JOIN equipes e1 ON p.id_equipe_casa = e1.id
                   JOIN equipes e2 ON p.id_equipe_fora = e2.id
                   ORDER BY p.data_partida DESC, p.hora_partida DESC";

$result = $link->query($sql);
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
        .container-table {
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        h3 {
            color: #2FB659; /* Cor verde para manter a consistência */
        }
    </style>
    <title>Resultados dos Jogos</title>
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


    <!-- Tabela de Resultados -->
    <div class="container-table mt-5 p-4">
        <h3 class="text-center mb-4">Resultados dos Jogos</h3>
        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Equipe Casa</th>
                        <th>Equipe Fora</th>
                        <th>Placar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($row['data_partida'])); ?></td>
                            <td><?= date('H:i', strtotime($row['hora_partida'])); ?></td>
                            <td><?= $row['equipe_casa']; ?></td>
                            <td><?= $row['equipe_fora']; ?></td>
                            <td><?= $row['gols_equipe_casa'] . ' - ' . $row['gols_equipe_fora']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning text-center" role="alert">
                Nenhum resultado encontrado.
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
