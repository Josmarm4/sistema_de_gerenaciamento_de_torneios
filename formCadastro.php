<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <style>
      body {
        background-color: #f8f9fa;
        margin: 0; /* Remove margens padrão */
        padding-top: 60px; /* Espaço para a navbar fixa */
      }
      .navbar-custom {
        background-color: #2FB659;
        width: 100%; /* Certifica-se que a navbar ocupa a largura total */
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
        margin: 20px auto; /* Centraliza o formulário e dá um espaço vertical */
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
      .left-panel p {
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
      .right-panel p {
        margin-bottom: 20px;
        color: #6c757d;
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

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
      <a class="navbar-brand" href="#">IFPR - Esportes</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Sobre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contato</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Formulário de Cadastro -->
    <div class="container-form">
      <div class="left-panel text-center">
        <h2>Bem-Vindo</h2>
        <p>Acesse sua conta agora mesmo</p>
        <a href="login.php">
            <button class="btn btn-outline-light">Entrar</button>
        </a>
      </div>

      <div class="right-panel">
        <h3 class="text-center">Crie sua Conta</h3>
        <p class="text-center">Preencha seus dados</p>

        <form action="cadastro.php" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label for="nome" class="form-label">*Nome:</label>
            <input type="text" class="form-control" placeholder="Informe o seu nome Completo" name="nome" id="nome" required>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">*Email:</label>
            <input type="email" class="form-control" placeholder="Informe o email" name="email" id="email" required>
          </div>

          <div class="form-group">
            <label for="senha" class="form-label">*Senha:</label>
            <input type="password" class="form-control" placeholder="Informe uma Senha" name="senha" id="senha" required>
          </div>

          <div class="form-group">
            <label for="confirmarSenha" class="form-label">*Confirme a Senha:</label>
            <input type="password" class="form-control" placeholder="Confirme a Senha" name="confirmarSenha" id="confirmarSenha" required>
          </div>

          <div class="form-group">
            <label for="telefone" class="form-label">*Telefone:</label>
            <input type="text" class="form-control" placeholder="Informe o TELEFONE" name="telefone" id="telefone" required>
          </div>

          <div class="form-group">
            <label for="dtNascimento" class="form-label">*Data de Nascimento:</label>
            <input type="date" class="form-control" name="dtNascimento" id="dtNascimento" required>
          </div>

          <div class="text-center mt-4 mb-4">
            <button type="submit" class="btn btn-custom btn-block">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
