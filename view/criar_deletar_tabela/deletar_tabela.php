<!DOCTYPE html>
<html lang="en">

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
    <script>
        //função para pergunta ao usuario ele realmente deseja apagar esta tabela
        function confirmar_delete(event) {

            if (!confirm("Você deseja realmente apagar esta tabela?")) {
                event.preventDefault();
                alert("Banco não apagado!");
            }
        }
    </script>


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
                    <a href=\"../info_banco_tabela/info_tabela.php?nome_banco=" . $matriz_bancos['Database'] . "&nome_tabela=" . $matriz_tabelas['Tables_in_' . $matriz_bancos['Database']] . "\">" . $matriz_tabelas['Tables_in_' . $matriz_bancos['Database']] . "</a></li>";
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
        <h1>Deletar tabela</h1>

        <?php

        //se existir o get"nome_banco"
        if (isset($_GET['nome_banco'])) {

            //criando a variavel nome_banco com o get passado
            $nome_banco = $_GET['nome_banco'];

            //requerindo o arquivo "conect_database.php"
            require('../../model/database/conect_database.php');

            //criando a variavel para entrar no banco
            $sql_use_banco = "USE $nome_banco";
            //executando o codigo no banco
            $result_use_banco = $conexao->query($sql_use_banco);

            //criando a variavel para mostrar todas as tabelas de um banco
            $sql_show_tables = "SHOW TABLES";
            //executando o codigo
            $result_show_tables = $conexao->query($sql_show_tables);

            //enquanto a variavel matriz for igual a função fetch_assoc
            while ($matriz_deletar_tabela = mysqli_fetch_assoc($result_show_tables)) {

                //criando a lista com formularios para deletar a tabela
                echo "<form action=\"../../controller/controller_criar_deletar_tabela/controller_deletar_tabela.php\" method=\"post\">";
                echo "<ul>";
                echo "<li>"
                    . $matriz_deletar_tabela['Tables_in_' . $nome_banco]
                    . "<input type=\"hidden\" name=\"nome_banco\" value=" . $nome_banco . ">
                <input type=\"hidden\" name=\"nome_tabela\" value=" . $matriz_deletar_tabela['Tables_in_' . $nome_banco] . "> 
                <button type=\"submit\" name=\"deletar_banco\" onclick=\"confirmar_delete(event)\">Deletar banco</button></li>";
                echo "</ul>";
                echo "</form>";
            }
        }
        ?>
        <?php

        //se existir um get"certo"
        if (isset($_GET['certo'])) {

            echo "Tabela deletada com sucesso!";
        }
        //se existir um get"erro"
        if (isset($_GET['erro'])) {

            echo "Erro ao deletar a tabela!";
        }
        //se existir um get"FATAL"
        if (isset($_GET['FATAL'])) {
            echo "Houve algum erro! Tente novamente";
        }
        ?>
    </section>

</body>

</html>