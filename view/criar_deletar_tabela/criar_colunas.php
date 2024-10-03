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

        //se existir "nome_numero_tabela" e existir "nome_banco" e nao estiver vazio a variavel "nome_tabela" e nao estiver vazio a variavel "numero_coluna"
        if (isset($_POST['nome_numero_tabela']) && isset($_GET['nome_banco']) && !empty($_POST['nome_tabela']) && !empty($_POST['numero_coluna'])) {

            //criando as variaveis com os valores passados
            $nome_tabela = $_POST['nome_tabela'];
            $numero_coluna = $_POST['numero_coluna'];
            $nome_banco = $_GET['nome_banco'];

            //escrevendo o formulario
            echo "<form action=\"../../controller/controller_criar_deletar_tabela/controller_criar_tabela.php\" method=\"post\">";

            echo "<p>Nome da tabela:" . $nome_tabela . "</p>";
            echo "<p>Número de tabelas: " . $numero_coluna . "</p>";

            echo "<input type=\"hidden\" name=\"nome_tabela\" value=\"$nome_tabela\">";
            echo "<input type=\"hidden\" name=\"nome_banco\" value=\"$nome_banco\">";
            echo "<table>";
            echo "<tr>";
            echo "<td>Nome</td>";
            echo "<td>Tipo</td>";
            echo "<td>Tamanho</td>";
            echo "<td>Não nulo</td>";
            echo "<td>Auto-incrementavel</td>";
            echo "<td>Primaria</td>";
            echo "</tr>";

            $i = $numero_coluna;
            while ($i >= 1) {

                echo "<tr>";
                echo "<td><input type:\"text\" name=\"nome_coluna\" id=\"criartabelajs\" required></td>";
                echo "<td>
                <select name=\"tipo_coluna\" required>
                    <option value=\"INT\">INT</option>
                    <option value=\"VARCHAR\">VARCHAR</option>
                    <option value=\"TEXT\">TEXT</option>
                    <option value=\"TIME\">TIME</option>
                    <option value=\"DATE\">DATE</option>
                    
                </select> 
              </td>";
                echo "<td><input type=\"number\" name=\"tamanho_coluna\" ></td>";
                echo "<td><input type=\"checkbox\" name=\"nao_nulo_coluna\" value=\"NOT NULL\"></td>";
                echo "<td><input type=\"checkbox\" name=\"auto_incre_coluna\" value=\"PRIMARY KEY\"></td>";
                echo "<td><input type=\"radio\" name=\"primario_coluna\" value=\"AUTO_INCREMENT\"></td>";
                echo "</tr>";
                $i--;
            }
            echo "</table>";
            echo "<button type=\"submit\" name=\"criar_tabela\">Criar tabela</button>";
            echo "</form>";
        }
        ?>
        <script>
            //criando a constante input 
            const input = document.getElementById('criartabelajs');

            //criando a função para inpedir que o usuario coloque valores comecando com um numero 
            input.addEventListener('input', function() {
                // Verifica se o primeiro caractere é um número
                if (/^\d/.test(this.value)) {
                    // Remove o primeiro caractere se for um número
                    this.value = this.value.slice(1);
                }
            });
            //criando a constante espaco
            const espaco = document.getElementById('criartabelajs');
            
            //criando a função para inpedir que o usuario coloque espaços
            input.addEventListener('keypress', function(event) {
                if (event.key === ' ') {
                    event.preventDefault(); // Impede a inserção de espaços
                }
            });
        </script>
    </section>
</body>

</html>