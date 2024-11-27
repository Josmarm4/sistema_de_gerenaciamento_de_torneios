<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php"); // Redireciona para o login caso o usuário não seja admin
    exit;
}

// Adicionar novo torneio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_torneio'])) {
    $nome_torneio = $_POST['nome_torneio'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $local_torneio = $_POST['local'];
    $regras = $_POST['regras'];

    // Inserir novo torneio no banco de dados
    $sql = "INSERT INTO torneios (nome_torneio, descricao, data_inicio, data_fim, local_torneio, regras) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ssssss", $nome_torneio, $descricao, $data_inicio, $data_fim, $local_torneio, $regras);

    if ($stmt->execute()) {
        $sucesso = "Torneio adicionado com sucesso!";
    } else {
        $erro = "Erro ao adicionar torneio!";
    }

    $stmt->close();
}

// Obter todos os torneios cadastrados
$sql = "SELECT * FROM torneios";
$result = $link->query($sql);
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
    <title>Gerenciar Torneios</title>
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

    <!-- Conteúdo Principal -->
    <div class="container-table">
        <h3 class="text-center mb-4">Gerenciar Torneios</h3>

        <!-- Exibir Mensagens de Sucesso ou Erro -->
        <?php if (isset($erro)) : ?>
            <div class="alert alert-danger text-center"><?= $erro; ?></div>
        <?php endif; ?>
        <?php if (isset($sucesso)) : ?>
            <div class="alert alert-success text-center"><?= $sucesso; ?></div>
        <?php endif; ?>

        <!-- Formulário para Adicionar Torneio -->
        <h5>Adicionar Novo Torneio</h5>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome_torneio">Nome do Torneio</label>
                <input type="text" class="form-control" id="nome_torneio" name="nome_torneio" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="data_inicio">Data de Início</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
            </div>
            <div class="form-group">
                <label for="data_fim">Data de Fim</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim" required>
            </div>
            <div class="form-group">
                <label for="local">Local</label>
                <input type="text" class="form-control" id="local" name="local" required>
            </div>
            <div class="form-group">
                <label for="regras">Regras</label>
                <textarea class="form-control" id="regras" name="regras" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom btn-block" name="adicionar_torneio">Adicionar Torneio</button>
        </form>

        <!-- Lista de Torneios -->
        <h5 class="mt-5">Lista de Torneios</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data de Início</th>
                    <th scope="col">Data de Fim</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome_torneio']); ?></td>
                        <td><?= htmlspecialchars($row['descricao']); ?></td>
                        <td><?= htmlspecialchars($row['data_inicio']); ?></td>
                        <td><?= htmlspecialchars($row['data_fim']); ?></td>
                        <td>
                            <a href="editar_torneio.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar_torneio.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Deletar</a>
                        </td>
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