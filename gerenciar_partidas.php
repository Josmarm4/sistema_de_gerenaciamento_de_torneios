<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php"); // Redireciona para o login caso o usuário não esteja autenticado ou não seja admin
    exit;
}

// Adicionar nova partida
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_partida'])) {
    $id_torneio = $_POST['id_torneio'];
    $id_equipe_casa = $_POST['id_equipe_casa'];
    $id_equipe_fora = $_POST['id_equipe_fora'];
    $data_partida = $_POST['data_partida'];
    $hora_partida = $_POST['hora_partida'];
    $local_torneio = $_POST['local_torneio']; // Alterado para local_torneio

    // Inserir nova partida no banco de dados
    $sql = "INSERT INTO partidas (id_torneio, id_equipe_casa, id_equipe_fora, data_partida, hora_partida, local_torneio) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("iiisss", $id_torneio, $id_equipe_casa, $id_equipe_fora, $data_partida, $hora_partida, $local_torneio);

    if ($stmt->execute()) {
        $sucesso = "Partida agendada com sucesso!";
    } else {
        $erro = "Erro ao agendar partida!";
    }

    $stmt->close();
}

// Obter torneios e equipes para preencher os campos do formulário
$sql_torneios = "SELECT * FROM torneios";
$torneios_result = $link->query($sql_torneios);

$sql_equipes = "SELECT * FROM equipes";
$equipes_result = $link->query($sql_equipes);

// Obter todas as partidas agendadas
$sql_partidas = "SELECT p.id, t.nome_torneio, e1.nome_equipe AS equipe_casa, e2.nome_equipe AS equipe_fora, p.data_partida, p.hora_partida, p.local_torneio 
                 FROM partidas p
                 JOIN torneios t ON p.id_torneio = t.id
                 JOIN equipes e1 ON p.id_equipe_casa = e1.id
                 JOIN equipes e2 ON p.id_equipe_fora = e2.id";
$partidas_result = $link->query($sql_partidas);
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
        .btn-custom {
            background-color: #2FB659;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #279149;
            border-color: #279149;
        }
        .table thead {
            background-color: #2FB659;
            color: white;
        }
    </style>
    <title>Gerenciar Partidas</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="#">IFPR - Esportes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="painel_administrador.php">Painel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pagina_principal.php">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Gerenciamento de Partidas -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Gerenciar Partidas</h3>
        <?php if (isset($erro)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $erro; ?>
            </div>
        <?php } ?>
        <?php if (isset($sucesso)) { ?>
            <div class="alert alert-success" role="alert">
                <?= $sucesso; ?>
            </div>
        <?php } ?>

        <!-- Formulário para adicionar partida -->
        <div class="mb-4">
            <h5>Adicionar Nova Partida</h5>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="id_torneio">Selecione o Torneio</label>
                    <select class="form-control" id="id_torneio" name="id_torneio" required>
                        <?php while ($torneio = $torneios_result->fetch_assoc()) { ?>
                            <option value="<?= $torneio['id']; ?>"><?= $torneio['nome_torneio']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_equipe_casa">Selecione a Equipe Casa</label>
                    <select class="form-control" id="id_equipe_casa" name="id_equipe_casa" required>
                        <?php while ($equipe = $equipes_result->fetch_assoc()) { ?>
                            <option value="<?= $equipe['id']; ?>"><?= $equipe['nome_equipe']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_equipe_fora">Selecione a Equipe Fora</label>
                    <select class="form-control" id="id_equipe_fora" name="id_equipe_fora" required>
                        <?php while ($equipe = $equipes_result->fetch_assoc()) { ?>
                            <option value="<?= $equipe['id']; ?>"><?= $equipe['nome_equipe']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_partida">Data da Partida</label>
                    <input type="date" class="form-control" id="data_partida" name="data_partida" required>
                </div>
                <div class="form-group">
                    <label for="hora_partida">Hora da Partida</label>
                    <input type="time" class="form-control" id="hora_partida" name="hora_partida" required>
                </div>
                <div class="form-group">
                    <label for="local_torneio">Local do Torneio</label>
                    <input type="text" class="form-control" id="local_torneio" name="local_torneio" required>
                </div>
                <button type="submit" class="btn btn-custom" name="adicionar_partida">Adicionar Partida</button>
            </form>
        </div>

        <!-- Tabela de Partidas -->
        <h5>Lista de Partidas</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Torneio</th>
                    <th scope="col">Equipe Casa</th>
                    <th scope="col">Equipe Fora</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Local</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($partida = $partidas_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $partida['nome_torneio']; ?></td>
                        <td><?= $partida['equipe_casa']; ?></td>
                        <td><?= $partida['equipe_fora']; ?></td>
                        <td><?= $partida['data_partida']; ?></td>
                        <td><?= $partida['hora_partida']; ?></td>
                        <td><?= $partida['local_torneio']; ?></td>
                        <td>
                            <a href="editar_partida.php?id=<?= $partida['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar_partida.php?id=<?= $partida['id']; ?>" class="btn btn-danger btn-sm">Deletar</a>
                        </td>
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
