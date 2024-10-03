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
        <?php

        //criando a variavel com o get passado
        $nome_banco = $_GET['database'] ?? 0;
        ?>
        <form action="criar_colunas.php?nome_banco=<?= $nome_banco ?>" method="post">
            <label for="nome">Nome tabela:</label>
            <input type="text" name="nome_tabela" id="criartabelajs" required placeholder="Nome"><br>
            <label for="numero">Número de colunas:</label>
            <input type="number" name="numero_coluna" id="numero" required placeholder="Número"><br>
            <button type="submit" name="nome_numero_tabela">Continuar</button><br>
        </form>
        <?php

        //se existir o get"certo"
        if (isset($_GET['certo'])) {

            echo "Tabela criada com sucesso!";
        }
        
        //se existir o get"erro"
        if (isset($_GET['erro'])) {

            echo "Erro ao criar a tabela!";
        }
        
        //se existir o get"FATAL"
        if (isset($_GET['FATAL'])) {
            echo "Houve algum erro! Tente novamente";
        }

        
        //se existir o get"ja_existe"
        if (isset($_GET['ja_existe'])) {

            echo "A tabela já existe!";
        }
        ?>
    </section>
    <script>
        const input = document.getElementById('criartabelajs');

        input.addEventListener('input', function() {
            // Verifica se o primeiro caractere é um número
            if (/^\d/.test(this.value)) {
                // Remove o primeiro caractere se for um número
                this.value = this.value.slice(1);
            }
        });

        const espaco = document.getElementById('criartabelajs');
        input.addEventListener('keypress', function(event) {
            if (event.key === ' ') {
                event.preventDefault(); // Impede a inserção de espaços
            }
        });
    </script>

</body>

</html>