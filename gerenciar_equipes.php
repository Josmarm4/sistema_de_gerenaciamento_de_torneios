<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php"); // Redireciona para o login caso o usuário não esteja autenticado ou não seja admin
    exit;
}

// Adicionar nova equipe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_equipe'])) {
    $nome_equipe = $_POST['nome_equipe'];
    $treinador = $_POST['treinador'];
    $contato = $_POST['contato'];

    // Inserir nova equipe no banco de dados
    $sql = "INSERT INTO equipes (nome_equipe, treinador, contato) VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sss", $nome_equipe, $treinador, $contato);

    if ($stmt->execute()) {
        $sucesso = "Equipe adicionada com sucesso!";
    } else {
        $erro = "Erro ao adicionar equipe!";
    }

    $stmt->close();
}

// Obter todas as equipes cadastradas
$sql = "SELECT * FROM equipes";
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
    <title>Gerenciar Equipes</title>
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

    <!-- Gerenciamento de Equipes -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Gerenciar Equipes</h3>
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

        <!-- Formulário para adicionar equipe -->
        <div class="mb-4">
            <h5>Adicionar Nova Equipe</h5>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome_equipe">Nome da Equipe</label>
                    <input type="text" class="form-control" id="nome_equipe" name="nome_equipe" required>
                </div>
                <div class="form-group">
                    <label for="treinador">Treinador</label>
                    <input type="text" class="form-control" id="treinador" name="treinador" required>
                </div>
                <div class="form-group">
                    <label for="contato">Contato</label>
                    <input type="text" class="form-control" id="contato" name="contato" required>
                </div>
                <button type="submit" class="btn btn-custom" name="adicionar_equipe">Adicionar Equipe</button>
            </form>
        </div>

        <!-- Tabela de Equipes -->
        <h5>Lista de Equipes</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Treinador</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['nome_equipe']; ?></td>
                        <td><?= $row['treinador']; ?></td>
                        <td><?= $row['contato']; ?></td>
                        <td>
                            <a href="editar_equipe.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar_equipe.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Deletar</a>
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
