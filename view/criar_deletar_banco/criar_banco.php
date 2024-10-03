<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USQL</title>
    <style>
        nav {
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

        <form action="../../controller/controller_criar_deletar_banco/controller_criar_banco.php" method="post">
            <input type="text" name="nome_banco" id="criarbancojs" required pattern="\S+">
            <button type="submit" name="criar_banco">Criar Banco</button><br>
        </form><br>
        <?php

        // se existir o get"certo"
        if (isset($_GET['certo'])) {
            $nome_banco = $_GET['certo'];
            echo "Banco $nome_banco criado com sucesso!";
        }
        // se existir o get"erro"
        if (isset($_GET['erro'])) {
            echo "Erro ao criar o banco!";
        }
        // se existir o get"ja_existe"
        if (isset($_GET['ja_existe'])) {
            echo "Já existe um banco esse nome!";
        }
        ?>
    </section>

    <script>
        const input = document.getElementById('criarbancojs');

        input.addEventListener('input', function() {
            // Verifica se o primeiro caractere é um número
            if (/^\d/.test(this.value)) {
                // Remove o primeiro caractere se for um número
                this.value = this.value.slice(1);
            }
        });
        const espaco = document.getElementById('criarbancojs');
        input.addEventListener('keypress', function(event) {
            if (event.key === ' ') {
                event.preventDefault(); // Impede a inserção de espaços
            }
        });
    </script>
</body>

</html>