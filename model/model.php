<?php

function criar_banco($nome_banco)
{
    //requerindo o arquivo conect_database.php
    require('database/conect_database.php');
    //criando a variavel para mostrar todos os banco de dados
    $sql_check = "SHOW DATABASES";
    //executando o codigo
    $result_check = $conexao->query($sql_check);

    //enquanto a variavel array for igual a função fetch_assoc
    while ($array = mysqli_fetch_assoc($result_check)) {

        //se array com o paramento database for igual a variavel nome_banco
        if ($array['Database'] == $nome_banco) {
            //redireciona para o arquivo controller_criar_banco.php
            header('location:../controller_criar_deletar_banco/controller_criar_banco.php?ja_existe');
        }
    }

    //criando variavel para criar um banco de dados
    $sql_criar_banco = "CREATE DATABASE $nome_banco";
    //executando o codigo
    $result_criar_banco = $conexao->query($sql_criar_banco);

    //se o $result_criar_banco for verdadeiro
    if ($result_criar_banco) {
        //redirecionado para o arquivo controller_criar_banco.php
        header('location:../controller_criar_deletar_banco/controller_criar_banco.php?certo=' . $nome_banco);
    } else {
        //redirecionado para o arquivo controller_criar_banco.php
        header('location:../controller_criar_deletar_banco/controller_criar_banco.php?erro');
    }
}

function deletar_banco($nome_banco)
{
    //requerindo o arquivo conect_database.php
    require('database/conect_database.php');
    //criando a variavel para deletar a tabela 
    $sql_deletar_banco = "DROP DATABASE $nome_banco";
    //executando o codigo
    $result_deletar_banco = $conexao->query($sql_deletar_banco);

    //se o $result_deletar_banco for verdadeiro
    if ($result_deletar_banco) {
        //redirecionado para o arquivo controller_deletar_banco.php
        header('location:../controller_criar_deletar_banco/controller_deletar_banco.php?certo=' . $nome_banco);
    } else {
        //redirecionado para o arquivo controller_deletar_banco.php
        header('location:../controller_criar_deletar_banco/controller_deletar_banco.php?erro');
    }
}

function criar_tabela($nome_banco, $nome_tabela, $nome_coluna, $tipo_coluna, $tamanho_coluna, $nao_nulo_coluna, $auto_incre_coluna, $primario_coluna)
{

    //requerindo o arquivo conect_database.php
    require('database/conect_database.php');
    //criando a variavel para entrar no banco
    $sql_check_tabela_entrar = "USE $nome_banco";
    //executando o codigo
    $result_check_tabela = $conexao->query($sql_check_tabela_entrar);

    //criando a variavel para mostrar todas as tabelas
    $sql_check_tabela = "SHOW TABLES";
    //executando o codigo
    $result_check_tabela = $conexao->query($sql_check_tabela);

    //enquanto matriz_tabelas for igual a fetch_assoc
    while ($matriz_tabelas = mysqli_fetch_assoc($result_check_tabela)) {

        //se matriz_tabela com o parametro passado for igual ao nome tabela
        if ($matriz_tabelas['Tables_in_' . $nome_banco] == $nome_tabela) {

            //redirecionando para a tabela controller_criar_tabela.php
            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?ja_existe');
        }
    }

    //se a variavel tipo_coluna for igual a DATE
    if ($tipo_coluna == "DATE") {

        $tamanho_coluna = "";
        $nao_nulo_coluna = "";
        $primario_coluna = "";
        $auto_incre_coluna = "";
        //criando a variavel para criar uma tabela
        $sql_criar_tabela = "CREATE TABLE $nome_tabela (
    
        $nome_coluna $tipo_coluna $primario_coluna $nao_nulo_coluna $auto_incre_coluna
    );";
        //executando o codigo
        $result_criar_tabela = $conexao->query($sql_criar_tabela);

        //se result_criar_tabela for verdadeiro
        if ($result_criar_tabela) {

            //redirecionando para a tabela controller_criar_tabela.php
            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?certo');
        } else {

            //redirecionando para a tabela controller_criar_tabela.php
            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?erro');
        }
    } else if ($nao_nulo_coluna == "") {
        $nao_nulo_coluna = "NOT NULL";
        //se nao, fazendo mesmo que o codigo anterior
        $sql_criar_tabela = "CREATE TABLE $nome_tabela (
    
        $nome_coluna $tipo_coluna($tamanho_coluna) $primario_coluna $nao_nulo_coluna $auto_incre_coluna
        );";

        $result_criar_tabela = $conexao->query($sql_criar_tabela);

        if ($result_criar_tabela) {

            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?certo');
        } else {

            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?erro');
        }
    } else { //se nao, fazendo mesmo que o codigo anterior
        $sql_criar_tabela = "CREATE TABLE $nome_tabela (
    
        $nome_coluna $tipo_coluna($tamanho_coluna) $primario_coluna $nao_nulo_coluna $auto_incre_coluna
        );";

        $result_criar_tabela = $conexao->query($sql_criar_tabela);

        if ($result_criar_tabela) {

            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?certo');
        } else {

            header('location:../controller_criar_deletar_tabela/controller_criar_tabela.php?erro');
        }
    }
}

function deletar_tabela($nome_banco, $nome_tabela)
{

    //requerindo o arquivo conect_database.php
    require('database/conect_database.php');

    //criando a variavel para entrar no banco
    $sql_use_tabela = "USE $nome_banco";
    //executando o codigo
    $result_use_tabela = $conexao->query($sql_use_tabela);

    //criando a variavel para deletar a tabela
    $sql_delete_tabela = "DROP TABLE $nome_tabela";
    //executando o codigo
    $result_delete_tabela = $conexao->query($sql_delete_tabela);
    //se result_deletar_tabela for verdadeiro
    if ($result_delete_tabela) {

        //redirecionando para a tabela controller_deletar_tabela.php
        header('location:../controller_criar_deletar_tabela/controller_deletar_tabela.php?certo');
    } else {

        //redirecionando para a tabela controller_deletar_tabela.php
        header('location:../controller_criar_deletar_tabela/controller_deletar_tabela.php?erro');
    }
}
