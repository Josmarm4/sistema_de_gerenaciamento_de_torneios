<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';

// Consulta para obter as informações das partidas
$sql = "SELECT p.id, e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, p.data_partida, p.hora_partida, p.local_torneio
                 FROM partidas p
                 JOIN equipes e1 ON p.id_equipe_casa = e1.id
                 JOIN equipes e2 ON p.id_equipe_fora = e2.id
                 ORDER BY p.data_partida ASC, p.hora_partida ASC";

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
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #2FB659;
        }
    </style>
    <title>Tabela de Jogos</title>
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

    <!-- Tabela de Jogos -->
    <div class="container-table mt-5 p-4">
        <h3 class="text-center mb-4">Tabela de Jogos</h3>
        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Equipe Casa</th>
                        <th>Equipe Fora</th>
                        <th>Local</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($row['data_partida'])); ?></td>
                            <td><?= date('H:i', strtotime($row['hora_partida'])); ?></td>
                            <td><?= $row['equipe_casa']; ?></td>
                            <td><?= $row['equipe_fora']; ?></td>
                            <td><?= $row['local_torneio']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning text-center" role="alert">
                Nenhuma partida encontrada.
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/
