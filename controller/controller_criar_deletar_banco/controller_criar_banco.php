<?php

//se exitir um post"criar_banco" e nao estiver vazio o post"nome_banco"
if (isset($_POST['criar_banco']) && !empty($_POST['nome_banco'])) {

    //criando a variavel nome_banco com o post passado
    $nome_banco = $_POST['nome_banco'];
    //requerindo o arquivo "model.php"
    require('../../model/model.php');
    //chamando a função criar_banco
    criar_banco($nome_banco);
} else {

    //se nao enviando para o arquivo "criar_banco.php"
    header('location:../../view/criar_deletar_banco/criar_banco.php');
}
//se existir o get certo, enviando para o arquivo "criar_banco.php" com o get certo e criando a variavel
if (isset($_GET['certo'])) {
    $nome_banco = $_GET['certo'];
    header('location:../../view/criar_deletar_banco/criar_banco.php?certo=' . $nome_banco);
}
//se existir o get erro, enviando para o arquivo "criar_banco.php"
if (isset($_GET['erro'])) {
    header('location:../../view/criar_deletar_banco/criar_banco.php?erro');
}
//se existir o get ja_existe enviando para o arquivo "criar_banco.php"
if (isset($_GET['ja_existe'])) {
    header('location:../../view/criar_deletar_banco/criar_banco.php?ja_existe');
}
