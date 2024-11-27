<?php
/* Variáveis iniciais
$nome = $email = $senha = $confirmarSenha = $telefone = $dtNascimento = "";
$tudoCerto = true;

// Verifica o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação do campo NOME
    if (empty($_POST["nome"])) {
        echo "<div class='alert alert-warning'>O campo <strong>NOME</strong> é obrigatório!</div>";
        $tudoCerto = false;
    } else {
        $nome = testar_entrada($_POST["nome"]);
        if (!preg_match("/^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇºª\' \']*$/", $nome)) {
            echo "<div class='alert alert-warning'>O campo <strong>NOME</strong> só aceita letras!</div>";
            $tudoCerto = false;
        }
    }

    // Validação do campo EMAIL
    if (empty($_POST["email"])) {
        echo "<div class='alert alert-warning'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
        $tudoCerto = false;
    } else {
        $email = filter_var(testar_entrada($_POST["email"]), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo "<div class='alert alert-warning'>O <strong>EMAIL</strong> não é válido!</div>";
            $tudoCerto = false;
        }
    }

    // Validação do campo SENHA
    if (empty($_POST["senha"])) {
        echo "<div class='alert alert-warning'>O campo <strong>SENHA</strong> é obrigatório!</div>";
        $tudoCerto = false;
    } else {
        $senha = password_hash(testar_entrada($_POST["senha"]), PASSWORD_DEFAULT);
    }

    // Validação do campo CONFIRMAR SENHA
    if (empty($_POST["confirmarSenha"]) || !password_verify($_POST["confirmarSenha"], $senha)) {
        echo "<div class='alert alert-warning'>As <strong>SENHAS</strong> não coincidem!</div>";
        $tudoCerto = false;
    }

    // Validação do campo TELEFONE
    if (empty($_POST["telefone"])) {
        echo "<div class='alert alert-warning'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
        $tudoCerto = false;
    } else {
        $telefone = testar_entrada($_POST["telefone"]);
        if (!preg_match("/^\d{10,11}$/", $telefone)) {
            echo "<div class='alert alert-warning'>O <strong>TELEFONE</strong> deve conter apenas números (10-11 dígitos)!</div>";
            $tudoCerto = false;
        }
    }

    // Validação do campo DATA DE NASCIMENTO
    if (empty($_POST["dtNascimento"]) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST["dtNascimento"])) {
        echo "<div class='alert alert-warning'>A <strong>DATA DE NASCIMENTO</strong> é inválida!</div>";
        $tudoCerto = false;
    } else {
        $dtNascimento = testar_entrada($_POST["dtNascimento"]);
        [$ano, $mes, $dia] = explode("-", $dtNascimento);
        if (!checkdate((int)$mes, (int)$dia, (int)$ano)) {
            echo "<div class='alert alert-warning'>A <strong>DATA DE NASCIMENTO</strong> não é válida!</div>";
            $tudoCerto = false;
        }
    }

    // Se estiver tudo certo
    if ($tudoCerto) {
        include("conexaoBD.php");
        $stmt = $link->prepare("INSERT INTO cadastros (nome, email, senha, telefone, dtNascimento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $senha, $telefone, $dtNascimento);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Cadastro realizado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao tentar cadastrar: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}

// Função para sanitizar entradas
function testar_entrada($dado) {
    return htmlspecialchars(stripslashes(trim($dado)), ENT_QUOTES, 'UTF-8');
}*/
?>
