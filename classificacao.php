<?php
// Inclua a conexão com o banco de dados
include 'conexaoBD.php';

// Query para obter a classificação
$query = "SELECT e.nome_equipe, c.jogos, c.vitorias, c.empates, c.derrotas, c.pontos, c.gols_marcados, c.gols_sofridos, c.saldo_gols 
          FROM classificacao c 
          JOIN equipes e ON c.id_equipe = e.id 
          ORDER BY c.pontos DESC, c.saldo_gols DESC, c.gols_marcados DESC";
$result = $link->query($query);
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
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #2FB659;
            color: white;
            text-align: center;
        }
        .table tbody td {
            text-align: center;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
    <title>Classificação</title>
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

    <!-- Conteúdo da Página -->
    <div class="container-table mt-5">
        <h3 class="text-center mb-4">Classificação do Torneio</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Equipe</th>
                    <th>Jogos</th>
                    <th>Vitórias</th>
                    <th>Empates</th>
                    <th>Derrotas</th>
                    <th>Pontos</th>
                    <th>Gols Marcados</th>
                    <th>Gols Sofridos</th>
                    <th>Saldo de Gols</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome_equipe']); ?></td>
                            <td><?php echo htmlspecialchars($row['jogos']); ?></td>
                            <td><?php echo htmlspecialchars($row['vitorias']); ?></td>
                            <td><?php echo htmlspecialchars($row['empates']); ?></td>
                            <td><?php echo htmlspecialchars($row['derrotas']); ?></td>
                            <td><?php echo htmlspecialchars($row['pontos']); ?></td>
                            <td><?php echo htmlspecialchars($row['gols_marcados']); ?></td>
                            <td><?php echo htmlspecialchars($row['gols_sofridos']); ?></td>
                            <td><?php echo htmlspecialchars($row['saldo_gols']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Nenhuma classificação disponível.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
