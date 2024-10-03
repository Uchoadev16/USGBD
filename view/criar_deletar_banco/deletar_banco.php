<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USQL</title>
    <style>
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
        function confirmar_delete(event) {

            if (!confirm("Você deseja realmente apagar este banco?")) {
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
            <li><a href="criar_banco.php">Novo</a></li>

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
        <p><a href="deletar_banco.php">Deletar banco</a></p>
    </nav>

    <section>
        <h1>Deletar banco</h1>

        <?php

        //requerindo o arquivo "conect_database.php"
        require('../../model/database/conect_database.php');

        //criando a variavel para mostrar a lista de banco de dados
        $sql_mostrar_bancos = "SHOW DATABASES";
        //executando o codigo
        $result_mostrar_bancos = $conexao->query($sql_mostrar_bancos);

        //enquanto matriz_banco for igual a fetch_assoc
        while ($matriz_bancos = mysqli_fetch_assoc($result_mostrar_bancos)) {

            //escrevendo a lista de banco de dados com um formulario
            echo " <form action=\"../../controller/controller_criar_deletar_banco/controller_deletar_banco.php\" method=\"post\">";

            echo "<ul>";
            echo "<li>" . $matriz_bancos['Database'] .
                "<input type=\"hidden\" name=\"nome_banco\" value=\"" . $matriz_bancos['Database'] . "\">
                <button type='submit' name='deletar' onclick=\"confirmar_delete(event)\">Deletar</button><br></li>";
            echo "</form>";
            echo "</ul>";
        }
        ?>
        <?php

        //se existir um get"certo"
        if (isset($_GET['certo'])) {
            $nome_banco = $_GET['certo'];
            echo "Banco $nome_banco deletado com sucesso!";
        }
        //se existir um get"erro"
        if (isset($_GET['erro'])) {
            echo "Erro ao deletar o banco!";
        }
        ?>
    </section>
</body>

</html>