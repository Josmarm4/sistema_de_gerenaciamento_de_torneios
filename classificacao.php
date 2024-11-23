<?php
// Inclui o arquivo de conexão com o banco de dados
require 'conexaoBD.php';

$sql = "SELECT * FROM classificacao ORDER BY pontos DESC, saldo_gols DESC";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Equipe: " . $row['id_equipe'] . " - Pontos: " . $row['pontos'] . "<br>";
    }
} else {
    //echo "Nenhuma classificação encontrada.";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tabela de Classificação</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
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
            /* Estilo da tabela */
            .styled-table {
                width: 100%;
                border-collapse: collapse;
                color: #2FB659;
                margin: 25px 0;
                font-size: 18px;
                text-align: left;
            }

            .styled-table thead tr {
                background-color: #009879; /* Mesma cor da tela de login */
                color: #2FB659;
                text-align: center;
            }

            .styled-table th, .styled-table td {
                padding: 12px 15px;
                border: 1px solid #ddd;
            }

            .styled-table tbody tr:nth-child(even) {
                background-color: #f3f3f3;
            }

            .styled-table tbody tr:hover {
                background-color: #f1f1f1;
                cursor: pointer;
            }

            .title {
                text-align: center;
                font-size: 2rem;
                color: #2FB659;
                margin-bottom: 20px;
            }

            .container {
                width: 80%;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }

        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="index.php">IFPR - Esportes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro_equipes.php">Cadastro de Equipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscricao_torneio.php">Inscrição em Torneios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="criar_torneio.php">Criação de Torneios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="resultados_jogos.php">Resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="classificacao.php">Classificação</a>
                    </li>
                </ul>
        </div>
        </nav>
        <div class="container mt-5">
            <h1 class="text-center title">Tabela de Classificação</h1>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Time</th>
                        <th>Jogos</th>
                        <th>Pontos</th>
                        <th>Vitórias</th>
                        <th>Empates</th>
                        <th>Derrotas</th>
                        <th>Gols Marcados</th>
                        <th>Gols Sofridos</th>
                        <th>Saldo de Gols</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $posicao = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$posicao}</td>
                                    <td>{$row['nome_time']}</td>
                                    <td>{$row['jogos']}</td>
                                    <td>{$row['pontos']}</td>
                                    <td>{$row['vitorias']}</td>
                                    <td>{$row['empates']}</td>
                                    <td>{$row['derrotas']}</td>
                                    <td>{$row['gols_marcados']}</td>
                                    <td>{$row['gols_sofridos']}</td>
                                    <td>{$row['saldo_gols']}</td>
                                </tr>";
                            $posicao++;
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Nenhum dado disponível</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
