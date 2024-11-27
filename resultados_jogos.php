<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php"); // Redireciona para o login caso o usuário não seja admin
    exit;
}

// Registrar resultado de partida
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_resultado'])) {
    $id_partida = $_POST['id_partida'];
    $gols_equipe_casa = $_POST['gols_equipe_casa'];
    $gols_equipe_fora = $_POST['gols_equipe_fora'];
    $detalhes = $_POST['detalhes'];

    // Atualizar resultado da partida no banco de dados
    $sql = "UPDATE resultados SET gols_equipe_casa = ?, gols_equipe_fora = ?, detalhes = ? WHERE id_partida = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("iisi", $gols_equipe_casa, $gols_equipe_fora, $detalhes, $id_partida);

    if ($stmt->execute()) {
        $sucesso = "Resultado registrado com sucesso!";
    } else {
        $erro = "Erro ao registrar resultado!";
    }

    $stmt->close();
}

// Obter todas as partidas agendadas sem resultado
$sql_partidas = "SELECT p.id, t.nome_torneio, e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, p.data_partida, p.hora_partida 
                 FROM partidas p
                 JOIN torneios t ON p.id_torneio = t.id
                 JOIN equipes e1 ON p.id_equipe_casa = e1.id
                 JOIN equipes e2 ON p.id_equipe_fora = e2.id
                 WHERE NOT EXISTS (SELECT 1 FROM resultados r WHERE r.id_partida = p.id)";
$partidas_result = $link->query($sql_partidas);

// Obter todos os resultados já registrados
$sql_resultados = "SELECT r.id, t.nome_torneio, e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, r.gols_equipe_casa, r.gols_equipe_fora, r.detalhes, p.data_partida, p.hora_partida
                   FROM resultados r
                   JOIN partidas p ON r.id_partida = p.id
                   JOIN torneios t ON p.id_torneio = t.id
                   JOIN equipes e1 ON p.id_equipe_casa = e1.id
                   JOIN equipes e2 ON p.id_equipe_fora = e2.id";
$resultados_result = $link->query($sql_resultados);
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

        .btn-custom {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-custom:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
    <title>Resultados dos Jogos</title>
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

    <div class="container-table">
        <h3 class="text-center mb-4">Registrar Resultados dos Jogos</h3>

        <!-- Mensagens de Sucesso ou Erro -->
        <?php if (isset($erro)) : ?>
            <div class="alert alert-danger text-center"><?= $erro; ?></div>
        <?php endif; ?>
        <?php if (isset($sucesso)) : ?>
            <div class="alert alert-success text-center"><?= $sucesso; ?></div>
        <?php endif; ?>

        <!-- Formulário para Registrar Resultado -->
        <h5>Registrar Resultado</h5>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_partida">Selecione a Partida</label>
                <select class="form-control" id="id_partida" name="id_partida" required>
                    <?php while ($partida = $partidas_result->fetch_assoc()) : ?>
                        <option value="<?= $partida['id']; ?>">
                            <?= $partida['nome_torneio'] . ' - ' . $partida['equipe_casa'] . ' vs ' . $partida['equipe_fora']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="gols_equipe_casa">Gols da Equipe Casa</label>
                <input type="number" class="form-control" id="gols_equipe_casa" name="gols_equipe_casa" required>
            </div>
            <div class="form-group">
                <label for="gols_equipe_fora">Gols da Equipe Fora</label>
                <input type="number" class="form-control" id="gols_equipe_fora" name="gols_equipe_fora" required>
            </div>
            <div class="form-group">
                <label for="detalhes">Detalhes (Opcional)</label>
                <textarea class="form-control" id="detalhes" name="detalhes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-custom btn-block" name="registrar_resultado">Registrar Resultado</button>
        </form>

        <!-- Tabela de Resultados Registrados -->
        <h5 class="mt-5">Lista de Resultados</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Torneio</th>
                    <th scope="col">Equipe Casa</th>
                    <th scope="col">Equipe Fora</th>
                    <th scope="col">Gols Casa</th>
                    <th scope="col">Gols Fora</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($resultado = $resultados_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($resultado['nome_torneio']); ?></td>
                        <td><?= htmlspecialchars($resultado['equipe_casa']); ?></td>
                        <td><?= htmlspecialchars($resultado['equipe_fora']); ?></td>
                        <td><?= htmlspecialchars($resultado['gols_equipe_casa']); ?></td>
                        <td><?= htmlspecialchars($resultado['gols_equipe_fora']); ?></td>
                        <td><?= htmlspecialchars($resultado['data_partida']); ?></td>
                        <td><?= htmlspecialchars($resultado['hora_partida']); ?></td>
                        <td><?= htmlspecialchars($resultado['detalhes']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
