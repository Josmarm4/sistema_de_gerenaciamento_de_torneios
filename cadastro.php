<?php //include("validarSessao.php")?>

<?php
    //Declaração das variáveis
    $nome = $email = $senha = $confirmarSenha = $telefone = $dtNascimento = "";

    $tudoCerto = true; //Essa variável será responsável por verificar se os campos foram devidamente preenchidos;

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Verifica o método de envio do FORM;
        if(empty($_POST["nome"])){
            echo "<div class='alert azlert-warning'>O campo <strong>NOME</strong> é obrigatório!</div>";
            $tudoCerto = false;
        }
        else{
            $nome = testar_entrada($_POST["nome"]);
            //A função preg_match define uma regra para aceitar apenas caracteres deste conjunto
            if(!preg_match("/^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇºª\' \']*$/", $nome)){
                echo "<div class='alert lert-warning text-center'>Atenção no campo <strong>NOME</strong> somente letras são permitidas!</div>";
                $tudoCerto = false;
            }
        }

        
        // Validação do campo EMAIL
        if (empty($_POST["email"])) {
            echo "<div class='alert alert-warning'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
            $tudoCerto = false;
        } else {
            $email = testar_entrada($_POST["email"]);
        }

        // Validação do campo SENHA
        if (empty($_POST["senha"])) {
            echo "<div class='alert alert-warning'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $tudoCerto = false;
        } else {
            //Para criptografia segura password_hash.
            $senha = password_hash(testar_entrada($_POST["senha"]), PASSWORD_DEFAULT);
        }

        // Validação do campo CONFIRMAR SENHA
        if (empty($_POST["confirmarSenha"])) {
            echo "<div class='alert alert-warning'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
            $tudoCerto = false;
        } else {
            $confirmarSenha = testar_entrada($_POST["confirmarSenha"]);
            //Para verificar se as senhas utilizando password_verify
            if (!password_verify($confirmarSenha, $senha)) {
                echo "<div class='alert alert-warning'>Atenção! <strong>SENHAS DIFERENTES</strong>!</div>";
                $tudoCerto = false;
            }
        }

        // Validação do campo TELEFONE
        if (empty($_POST["telefone"])) {
            echo "<div class='alert alert-warning'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
            $tudoCerto = false;
        } else {
            $telefone = testar_entrada($_POST["telefone"]);
        }

        // Validação do campo DATA DE NASCIMENTO
        if (!empty($_POST["dtNascimento"])) {
            $dtNascimento = testar_entrada($_POST["dtNascimento"]);
            
            // Aplica a função strlen para contabilizar a quantidade de caracteres
            if (strlen($dtNascimento) == 10) {
                $dia = substr($dtNascimento, 8, 2);
                $mes = substr($dtNascimento, 5, 2);
                $ano = substr($dtNascimento, 0, 4);

                if (!checkdate($mes, $dia, $ano)) {
                    echo "<div class='alert alert-warning'>DATA <strong>INVÁLIDA</strong>!</div>";
                    $tudoCerto = false;
                }
            } else {
                echo "<div class='alert alert-warning'>DATA <strong>INVÁLIDA</strong>!</div>";
                $tudoCerto = false;
            }
        } else {
            echo "<div class='alert alert-warning'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
            $tudoCerto = false;
        }


         //Aplica a função strlen para contabilizar a quantidade de caracteres
         if(strlen($dtNascimento) == 10){
            $dia = substr($dtNascimento, 8, 2);
            $mes = substr($dtNascimento, 5, 2);
            $ano = substr($dtNascimento, 0, 4);

            if(!checkdate($mes, $dia, $ano)){
                echo "<div class='alert alert-warning'>DATA<strong>INVÁLIDA</strong>!</div>";
                $tudoCerto = false;
            }
        }
        else{
            echo "<div class='alert alert-warning'>DATA<strong>INVÁLIDA</strong>!</div>";
            $tudoCerto = false;
        }


        //Se estiver tudo certo
        if($tudoCerto){

            //Cria uma Query  responsável por realizar a inserção no BD
            $inserir = "INSERT INTO cadastros(nome, email, senha, telefone, dtNascimento)
                        VALUES ('$nome','$email','$senha','$telefone','$dtNascimento')";
            
            include("conexaoBD.php");

            //Função para executar Query's no BD
            if(mysqli_query($link, $inserir)){
                echo "<div class='alert alert-success text-center'><strong>Pessoa</strong> cadastrado(a) com sucesso!</div>";

                echo "<div class='container mt-3'>
                            <table class='table'>
                            <tr>
                                <th>NOME</th>
                                <td>$nome</td>
                            </tr>
                            <tr>
                                <th>EMAIL</th>
                                <td>$email</td>
                            </tr>
                            <tr>
                                <th>SENHA</th>
                                <td>$senha</td>
                            </tr>
                            <tr>
                                <th>CONFIRMAR SENHA</th>
                                <td>$confirmarSenha</td>
                            </tr>
                            <tr>
                                <th>TELEFONE</th>
                                <td>$telefone</td>
                            </tr>
                             <tr>
                                <th>DATA DE NASCIMENTO</th>
                                <td>$dia/$mes/$ano</td>
                            </tr>
                            </table>
                      </div>
                    ";
            }
            else{
                echo "<div class='alert alert-danger'>Erro ao tentar cadastrar <strong>DOCENTE</strong>!</div>" . mysqli_error($link);
            }

        }
    }

    //Função para testar as entradas de dados e evitar SQL Injection
    function testar_entrada($dado){
        $dado = trim($dado); //TRIM - Remove caracteres desnecessários (TABS, espaços, etc)
        $dado = stripslashes($dado); //Remove barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML
        return($dado);
    }
?>

<?php //include("footer.php");?>