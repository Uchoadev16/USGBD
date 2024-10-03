<?php
//se existir o post"criar_tabela" e nao estiver vazio o post"nome_banco" e não estiver vazio o post"nome_tabela" e nao estiver vazio o post"nome_coluna" e não estiver vazio o post"tipo_coluna"
if (isset($_POST['criar_tabela']) && !empty($_POST['nome_banco']) && !empty($_POST['nome_tabela']) && !empty($_POST['nome_coluna']) && !empty($_POST['tipo_coluna'])) {

    //criando as variaveis com o post passado
    $nome_banco = $_POST['nome_banco'];
    $nome_tabela = $_POST['nome_tabela'];
    $nome_coluna = $_POST['nome_coluna'];
    $tipo_coluna = $_POST['tipo_coluna'];
    $tamanho_coluna = $_POST['tamanho_coluna'];
    $nao_nulo_coluna = $_POST['nao_nulo_coluna'] ?? "";
    $auto_incre_coluna = $_POST['auto_incre_coluna'] ?? "";
    $primario_coluna = $_POST['primario_coluna'] ?? "";

    //requerindo o arquivo model.php
    require('../../model/model.php');
    //chamando a função criar_tabela
    criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna);
} else {
    //se nao, enviando para o arquivo criar_tabela.php
    header('location:../../view/criar_deletar_tabela/criar_tabela.php?FATAL');
}
//se existir um get certo, ele envia para o arquivo "criar_tabela.php"
if (isset($_GET['certo'])) {

    header('location:../../view/criar_deletar_tabela/criar_tabela.php?certo');
}
//se existir um get erro, ele envia para o arquivo "criar_tabela.php"
if (isset($_GET['erro'])) {

    header('location:../../view/criar_deletar_tabela/criar_tabela.php?erro');
}
//se existir um get ja_existe, ele envia para o arquivo "criar_tabela.php"
if (isset($_GET['ja_existe'])) {

    header('location:../../view/criar_deletar_tabela/criar_tabela.php?ja_existe');
}
