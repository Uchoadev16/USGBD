<?php

//se existir o post"deletar_banco" e não estiver vazio o post"nome_banco" e não estiver vazio o post"nome_tabela"
if (isset($_POST['deletar_banco']) && !empty($_POST['nome_banco']) && !empty($_POST['nome_tabela'])) {

    //criando as variaveis com os post passados
    $nome_banco = $_POST['nome_banco'];
    $nome_tabela = $_POST['nome_tabela'];

    //requerindo o arquivo model.php
    require('../../model/model.php');
    //chamando a função deletar_tabela
    deletar_tabela($nome_banco, $nome_tabela);
} else {
    //se nao, enviar para o arquivo deletar_tabela.php
    header('location:../../view/criar_deletar_tabela/deletar_tabela.php');
}
//se existir um get"certo" ele envia para o arquivo deletar_tabela
if (isset($_GET['certo'])) {

    header('location:../../view/criar_deletar_tabela/deletar_tabela.php?certo');
}
//se existir um get"erro" ele envia para o arquivo deletar_tabela
if (isset($_GET['erro'])) {

    header('location:../../view/criar_deletar_tabela/deletar_tabela.php?erro');
}
