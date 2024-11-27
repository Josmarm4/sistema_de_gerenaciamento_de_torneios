<?php
session_start();
include 'conexaoBD.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado e é um usuário comum
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] == 'admin') {
    header("Location: login.php"); // Redireciona caso o usuário não esteja logado ou seja admin
    exit;
}

// Obter as informações do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt_usuario = $link->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$stmt_usuario->bind_result($nome_usuario, $email_usuario);
$stmt_usuario->fetch();
$stmt_usuario->close();

// Atualizar informações do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se o formulário foi enviado para atualizar os dados
    if (isset($_POST['atualizar_dados'])) {
        $novo_nome = $_POST['nome'];
        $novo_email = $_POST['email'];

        $sql_atualizar = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmt_atualizar = $link->prepare($sql_atualizar);
        $stmt_atualizar->bind_param("ssi", $novo_nome, $novo_email, $usuario_id);

        if ($stmt_atualizar->execute()) {
            $mensagem = "Informações atualizadas com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar as informações!";
        }
        $stmt_atualizar->close();
    }

    // Atualizar senha do usuário
    if (isset($_POST['atualizar_senha'])) {
        $nova_senha = $_POST['nova_senha'];
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $sql_atualizar_senha = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt_atualizar_senha = $link->prepare($sql_atualizar_senha);
        $stmt_atualizar_senha->bind_param("si", $senha_hash, $usuario_id);

        if ($stmt_atualizar_senha->execute()) {
            $mensagem_senha = "Senha atualizada com sucesso!";
        } else {
            $mensagem_senha = "Erro ao atualizar a senha!";
        }
        $stmt_atualizar_senha->close();
    }
}

// Obter os torneios em que o usuário está inscrito
$sql_torneios_inscricao = "SELECT t.nome_torneio FROM torneios t
                           JOIN inscricoes i ON i.id_torneio = t.id
                           WHERE i.id_usuario = ?";
$stmt_torneios_inscricao = $link->prepare($sql_torneios_inscricao);
$stmt_torneios_inscricao->bind_param("i", $usuario_id);
$stmt_torneios_inscricao->execute();
$result_torneios = $stmt_torneios_inscricao->get_result();
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

        .btn-custom {
            background-color: #2FB659;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #279149;
            border-color: #279149;
        }
    </style>
    <title>Perfil do Usuário</title>
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

    <!-- Formulário de Perfil -->
    <div class="container">
        <h3>Perfil do Usuário</h3>
        
        <!-- Mensagem de Sucesso ou Erro -->
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-info text-center" role="alert">
                <?= $mensagem; ?>
            </div>
        <?php } ?>
        <?php if (isset($mensagem_senha)) { ?>
            <div class="alert alert-info text-center" role="alert">
                <?= $mensagem_senha; ?>
            </div>
        <?php } ?>

        <!-- Informações do Usuário -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome_usuario); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email_usuario); ?>" required>
            </div>
            <button type="submit" class="btn btn-custom" name="atualizar_dados">Atualizar Dados</button>
        </form>

        <!-- Alterar Senha -->
        <h5 class="mt-4">Alterar Senha</h5>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nova_senha">Nova Senha</label>
                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
            </div>
            <button type="submit" class="btn btn-custom" name="atualizar_senha">Alterar Senha</button>
        </form>

        <!-- Torneios em que o Usuário está Inscrito -->
        <h5 class="mt-4">Torneios em que você está inscrito</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome do Torneio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_torneios->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome_torneio']); ?></td>
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
