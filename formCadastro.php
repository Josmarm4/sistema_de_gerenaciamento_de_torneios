<?php
session_start();
include 'conexaoBD.php'; // Certifique-se de que a conexão com o banco de dados está correta

// Verificar se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: painel_administrador.php"); // Redireciona para o painel do administrador caso esteja logado
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // Criptografando a senha com MD5

    // Verifique se o e-mail já está registrado no banco
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "E-mail já registrado!";
    } else {
        // Inserir usuário no banco
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar!";
        }
    }
    $stmt->close();
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
        .left-panel h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .right-panel {
            padding: 40px;
            width: 60%;
        }
        .right-panel h3 {
            color: #2FB659;
            font-size: 24px;
            margin-bottom: 10px;
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
        .form-control::placeholder {
            color: #6c757d;
        }
    </style>
    <title>Cadastro</title>
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
                    <a class="nav-link" href="pagina_principal.php">Página Inicial</a>
                </li>
                <?php if (isset($_SESSION['usuario_tipo'])): ?>
                    <?php if ($_SESSION['usuario_tipo'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="painel_administrador.php">Painel de Administração</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Formulário de Cadastro -->
    <div class="container-form mt-5">
        <div class="left-panel text-center">
            <h2>Bem-Vindo</h2>
            <p>Já possui uma conta?</p>
            <a href="login.php">
                <button class="btn btn-outline-light">Faça Login</button>
            </a>
        </div>

        <div class="right-panel">
            <h3>Cadastro de Usuário</h3>
            <form method="POST" action="">

                <div class="form-group">
                    <label for="nome">*Nome:</label>
                    <input type="text" class="form-control" placeholder="Informe seu nome" name="nome" id="nome" required>
                </div>

                <div class="form-group">
                    <label for="email">*E-mail:</label>
                    <input type="email" class="form-control" placeholder="Informe seu e-mail" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="senha">*Senha:</label>
                    <input type="password" class="form-control" placeholder="Informe sua senha" name="senha" id="senha" required>
                </div>

                <div class="text-center mt-4 mb-4">
                    <button type="submit" class="btn btn-custom btn-block" name="cadastrar">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
