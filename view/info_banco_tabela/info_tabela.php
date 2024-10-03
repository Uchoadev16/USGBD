<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USGBD</title>
    <style>
        table {
            border: 1px solid black;
        }

        tr {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
            padding: 3px 3px 3px 3px;
        }

        nav {
            padding: 0px;
            border: 2px solid black;
            height: 675px;
            width: 200px;
        }

        section {
            border: 2px solid black;
            margin-left: 202px;
            margin-top: -678px;
            height: 675px;
            width: 1300px;
        }
    </style>

</head>

<body>
    <nav>
        <ul>
            <h1><a href="../index.php">USGBD</a></h1>
            <p>Databases</p>
            <li><a href="../criar_deletar_banco/criar_banco.php">Novo</a></li>

            <?php
            //requerindo o arquivo "conect_database.php"
            require('../../model/database/conect_database.php');
            //criando a variavel sql para mostrar a lista de banco de dados
            $sql_mostrar_bancos = "SHOW DATABASES";
            //executando o codigo no sql
            $result_mostrar_bancos = $conexao->query($sql_mostrar_bancos);
            //enquato a variavel matriz_banco for igual a função fetch_assoc
            while ($matriz_bancos = mysqli_fetch_assoc($result_mostrar_bancos)) {

                //criando a variavel sql para entrar no banco de dados
                $sql_entrar_banco = "USE " . $matriz_bancos['Database'] . ";";
                //executando o codigo no sql
                $result_entrar_banco = $conexao->query($sql_entrar_banco);

                $sql_mostrar_tabelas = "SHOW TABLES;";
                $result_mostrar_tabelas = $conexao->query($sql_mostrar_tabelas);

                //escrevendo um menu de opcoes com todos os banco de dados
                echo "<li>
                    <details>
                        <summary>" . $matriz_bancos['Database'] . "</summary>
                        <ul>
                              <li><a href=\"../criar_deletar_tabela/criar_tabela.php?database=" . $matriz_bancos['Database'] . "\">Novo</a></li>";

                //enquato a variavel matriz_banco for igual a função fetch_assoc
                while ($matriz_tabelas = mysqli_fetch_assoc($result_mostrar_tabelas)) {

                    //escrevendo um menu de opcoes com o todas as tabela do determinado banco de dados
                    echo "<li>
                    <a href=\"info_tabela.php?nome_banco=" . $matriz_bancos['Database'] . "&nome_tabela=" . $matriz_tabelas['Tables_in_' . $matriz_bancos['Database']] . "\">" . $matriz_tabelas['Tables_in_' . $matriz_bancos['Database']] . "</a></li>";
                }

                echo "      </ul>
                        <a href=\"../criar_deletar_tabela/deletar_tabela.php?nome_banco=" . $matriz_bancos['Database'] . "\">Deletar tabela</a>
                    </details>
                 </li>";
            }
            ?>
        </ul>

        <p><a href="../criar_deletar_banco/deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>

        <?php

        //se existir um get"nome_banco" e existir um get"nome_tabela" e não estiver vazio o nome_banco e nao estiver vazio o nome_tabela
        if (isset($_GET['nome_banco']) && isset($_GET['nome_tabela']) && !empty($_GET['nome_banco']) && !empty($_GET['nome_tabela'])) {

            //criando as variaveis via get
            $nome_banco = $_GET['nome_banco'];
            $nome_tabela = $_GET['nome_tabela'];

            echo "Descrição da tabela:<br>";

            //requerindo o arquivo "conect_database.php
            require('../../model/database/conect_database.php');

            //criando a variavel para entrar no banco
            $sql_entrar_banco = "USE $nome_banco";
            //executando o codigo
            $result_entrar_banco = $conexao->query($sql_entrar_banco);

            //criando a variavel para mostra a descrição da tabela
            $sql_desc_tabela = "DESC $nome_tabela";
            //executando o codigo
            $result_desc_tabela = $conexao->query($sql_desc_tabela);

            echo "<table>";
            echo "<tr>";
            echo "<td>Nome</td>";
            echo "<td>Tipo</td>";
            echo "<td>Não nulo</td>";
            echo "<td>Chave</td>";
            echo "<td>Default</td>";
            echo "<td>Extra</td>";
            echo "</tr>";

            //enquanto a matriz_tabela for igual a função fetch_assoc
            while ($matriz_tabela = mysqli_fetch_assoc($result_desc_tabela)) {

                //escrevendo os valores na tabela
                echo "<tr>";
                echo "<td>" . $matriz_tabela['Field'] . "</td>";
                echo "<td>" . $matriz_tabela['Type'] . "</td>";
                echo "<td>" . $matriz_tabela['Null'] . "</td>";
                echo "<td>" . $matriz_tabela['Key'] . "</td>";
                echo "<td>" . $matriz_tabela['Default'] . "</td>";
                echo "<td>" . $matriz_tabela['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table><br>";

            echo "Dados da tabela:";

            echo "<table>";
            echo "<tr>";

            //criando a variavel para mostra a descrição da tabela
            $sql_desc_coluna = "DESC $nome_tabela";
            //executando o codigo
            $result_desc_coluna = $conexao->query($sql_desc_coluna);
            //enquanto a matriz_coluna for igual a fetch_assoc
            while ($matriz_coluna = mysqli_fetch_assoc($result_desc_coluna)) {
                //escrevendo a variavel matriz_coluna com o paramentro passado
                echo "<td>" . $matriz_coluna['Field'] . "</td>";
            }
            echo "</tr>";

            //criando a variavel para seleciona todos os dados da tabela 
            $slq_select_dados = "SELECT * FROM $nome_tabela";
            //executando o codigo
            $result_select_dados = $conexao->query($slq_select_dados);

            //enquanto matriz_dados for igual a fetch_assoc
            while ($matriz_dados = mysqli_fetch_assoc($result_select_dados)) {
                echo "<tr>";
                //usando o foreach para transforma o vetor "matriz_dados" na variavel "dados", escrevendo ela em ate o vetor acaba 
                foreach ($matriz_dados as $dados) {
                    echo "<td>" . $dados . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </section>

</body>

</html>