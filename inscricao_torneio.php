<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário está logado e é um usuário comum
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] == 'admin') {
    header("Location: login.php"); // Redireciona caso o usuário não esteja logado ou seja admin
    exit;
}

// Verifica se o ID do torneio foi passado
if (isset($_GET['id'])) {
    $id_torneio = $_GET['id'];

    // Verifica se o torneio existe
    $sql = "SELECT nome_torneio FROM torneios WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $id_torneio);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Se o torneio não existir, redireciona o usuário
        header("Location: torneios_disponiveis.php");
        exit;
    }

    // Obtém o nome do torneio
    $stmt->bind_result($nome_torneio);
    $stmt->fetch();
    $stmt->close();

    // Verifica se o formulário foi enviado para inscrever o usuário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Inscrever o usuário no torneio
        $usuario_id = $_SESSION['usuario_id'];

        // Verifica se o usuário já está inscrito no torneio
        $sql_check = "SELECT * FROM inscricoes WHERE id_torneio = ? AND id_usuario = ?";
        $stmt_check = $link->prepare($sql_check);
        $stmt_check->bind_param("ii", $id_torneio, $usuario_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Usuário já está inscrito
            $mensagem = "Você já está inscrito neste torneio!";
        } else {
            // Realiza a inscrição
            $sql_insert = "INSERT INTO inscricoes (id_torneio, id_usuario) VALUES (?, ?)";
            $stmt_insert = $link->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $id_torneio, $usuario_id);
            if ($stmt_insert->execute()) {
                $mensagem = "Inscrição realizada com sucesso!";
            } else {
                $mensagem = "Erro ao realizar a inscrição: " . $link->error;
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
} else {
    header("Location: torneios_disponiveis.php"); // Caso o ID do torneio não seja encontrado
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

        .container-form {
            display: flex;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
            margin: 20px auto;
        }

        .left-panel {
            background-color: #2FB659;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 40%;
        }

        .right-panel {
            padding: 40px;
            width: 60%;
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
    </style>
    <title>Inscrição no Torneio</title>
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
                    <a class="nav-link" href="pagina_principal_administrador.php">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Formulário de Inscrição -->
    <div class="container-form mt-5">
        <div class="left-panel text-center">
            <h2>Inscrição no Torneio</h2>
            <p>Inscreva-se para o torneio <strong><?= htmlspecialchars($nome_torneio); ?></strong></p>
        </div>

        <div class="right-panel">
            <h3>Confirmar Inscrição</h3>
            <?php if (isset($mensagem)) { ?>
                <div class="alert alert-info text-center" role="alert">
                    <?= htmlspecialchars($mensagem); ?>
                </div>
            <?php } ?>
            <form method="POST" action="">
                <button type="submit" class="btn btn-custom btn-lg">Confirmar Inscrição</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
