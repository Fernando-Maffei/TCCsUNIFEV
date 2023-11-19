<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Repositório de TCC</title>
</head>
<body>

    <header>

        <a href="https://unifev.edu.br/" target="_blank">
            <img class="logotipo" src="https://unifev.edu.br/img/logounifev-rodape.png" alt="Logotipo Unifev" id="logo">
        </a>
        <nav>
            <ul>
                <li><a href="/Site/log.html" class="btn">UPLOAD</a></li>
                <li><a href="/Site/index.html" class="btn">PESQUISA TCC</a></li>
            </ul>
        </nav>

<?php
        // Configurações de conexão com o banco de dados
        $host = "localhost";
        $usuario = "root";
        $senha = "";
        $banco = "tcc_database";

        // Conectar ao banco de dados
        $conexao = new mysqli($host, $usuario, $senha, $banco);

        // Verificar a conexão
        if ($conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Verificar se as variáveis POST estão definidas antes de utilizá-las
        $searchCriteria = isset($_POST["searchCriteria"]) ? $_POST["searchCriteria"] : "";
        $searchTerm = isset($_POST["searchInput"]) ? $_POST["searchInput"] : "";

        // Evitar SQL injection escapando as variáveis
        $searchCriteria = $conexao->real_escape_string($searchCriteria);
        $searchTerm = $conexao->real_escape_string($searchTerm);

        // Consulta SQL para buscar documentos com base nos critérios de pesquisa
        $sql = "SELECT documents.id AS doc_id, documents.nome AS doc_nome, autores.nome AS autor_nome 
                FROM documents 
                LEFT JOIN autores ON documents.id = autores.id
                WHERE $searchCriteria LIKE '%$searchTerm%'";
        $resultado = $conexao->query($sql);

        // Exibir os resultados
        displayResults($resultado);

        // Fechar a conexão
        $conexao->close();

        // Função para exibir os resultados
        function displayResults($results) {
            $resultsContainer = '<div id="searchResults">';

            if ($results->num_rows === 0) {
                $resultsContainer .= 'Nenhum resultado encontrado.';
            } else {
                while ($result = $results->fetch_assoc()) {
                    $resultElement = '<div>';
                    $resultElement .= '<h3>Nome do Documento: ' . (isset($result["doc_nome"]) ? htmlspecialchars($result["doc_nome"]) : "") . '</h3>';
                    $resultElement .= '<p>Nome do Autor: ' . (isset($result["autor_nome"]) ? htmlspecialchars($result["autor_nome"]) : "") . '</p>';
                    
                    // Adiciona um link para visualizar o PDF
                    $resultElement .= '<a href="visualizar_pdf.php?id=' . $result["doc_id"] . '" target="_blank" class="btn">Visualizar PDF</a>';
                    
                    $resultElement .= '</div>';
                    $resultsContainer .= $resultElement;
                }
            }

            $resultsContainer .= '</div>';
            echo $resultsContainer;
        }
        ?>
    </header>
</body>
</html>
