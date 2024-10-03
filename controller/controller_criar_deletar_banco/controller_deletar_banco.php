<?php

//se existir um post"deletar" e não estiver vazio o post"nome_banco"
if (isset($_POST['deletar']) && !empty($_POST['nome_banco'])) {

    //criando a variavel com o post passado
    $nome_banco = $_POST['nome_banco'];
    //requerindo o arquivo.php
    require('../../model/model.php');
    //chamando a função deletar_banco
    deletar_banco($nome_banco);
} else {
    //se nao enviando para o arquivo deletar_banco.php
    header('location:../../view/criar_deletar_banco/deletar_banco.php?erro');
}
//se existir um get certo, enviando para o arquivo deletar_banco.php com a variavel criada
if (isset($_GET['certo'])) {
    $nome_banco = $_GET['certo'];
    header('location:../../view/criar_deletar_banco/deletar_banco.php?certo=' . $nome_banco);
}
//se existir um get erro, enviando para o arquivo deletar_banco.php 
if (isset($_GET['erro'])) {
    header('location:../../view/criar_deletar_banco/deletar_banco.php?erro');
}
