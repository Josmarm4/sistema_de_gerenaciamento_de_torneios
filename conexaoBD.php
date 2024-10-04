<?php

    $servidorBD = "localhost";
    $usuarioBD  = "root";
    $senhaBD    = "";
    $database   = "sistema_tcc";

    //Função do PHP para estabelecer conexao com o BD
    $link = mysqli_connect($servidorBD, $usuarioBD, $senhaBD, $database);

    if(!$link){
        echo "<p>Erro ao tentar conectar à Base de Dados <b>$database</b></p>";
    }

?>