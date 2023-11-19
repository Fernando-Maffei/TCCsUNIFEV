<?php
// Função para realizar a busca no banco de dados
function searchTCC($searchCriteria, $searchTerm) {
    // Configurações de conexão com o banco de dados
    $host = "localhost";  // Altere para o host do seu banco de dados
    $usuario = "root";    // Altere para o usuário do seu banco de dados
    $senha = "";          // Altere para a senha do seu banco de dados
    $banco = "repositoriotcc"; // Altere para o nome do seu banco de dados

    // Conectar ao banco de dados
    $conexao = new mysqli($host, $usuario, $senha, $banco);

    // Verificar a conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Consulta SQL para buscar TCCs com base nos critérios de pesquisa
    $sql = "SELECT id, title, preview, pdf_path FROM tccs WHERE $searchCriteria LIKE '%$searchTerm%'";
    $resultado = $conexao->query($sql);

    // Exibir os resultados
    displayResults($resultado);

    // Fechar a conexão
    $conexao->close();
}

// Função para exibir os resultados
function displayResults($results) {
    $resultsContainer = '<div id="searchResults">';

    if ($results->num_rows === 0) {
        $resultsContainer .= 'Nenhum resultado encontrado.';
    } else {
        while ($result = $results->fetch_assoc()) {
            $resultElement = '<div>';
            $resultElement .= '<h3>' . $result["title"] . '</h3>';
            $resultElement .= '<p>' . $result["preview"] . '</p>';

            // Adiciona um link para a pré-visualização do PDF
            $resultElement .= '<a href="visualizar_pdf.php?id=' . $result["id"] . '" target="_blank">Visualizar PDF</a>';

            $resultElement .= '</div>';
            $resultsContainer .= $resultElement;
        }
    }

    $resultsContainer .= '</div>';
    echo $resultsContainer;
}

// Exemplo de uso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchCriteria = $_POST["searchCriteria"];
    $searchTerm = $_POST["searchInput"];
    searchTCC($searchCriteria, $searchTerm);
}
?>

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

        <a href="https://unifev.edu.br/" target="__blank">
            <img class="logotipo" src="https://unifev.edu.br/img/logounifev-rodape.png" alt="Logotipo Unifev" id="logo">
        </a>
        <nav>
            <ul>
                <li><a href="/Site/upload.html" class="btn">Upload</a></li>
            </ul>
        </nav>
        <nav class="pesquisa">
            <h1>Pesquisa de TCC</h1>
            
    <form action="busca.php" method="post" class="pesquisa2">
        <br>
        <label for="searchCriteria">Critério de Pesquisa:</label>
        <select name="searchCriteria" id="searchCriteria">
            <!-- Adicione opções conforme necessário -->
            <option value="title">Título</option>
            <option value="preview">Autor</option>

        </select>
        <br>
        <br>
        <label for="searchInput">Termo de Pesquisa:</label>
        <input type="text" name="searchInput" id="searchInput" required>

        <input type="submit" value="Pesquisar">
    </form>

    <div id="searchResults">
        <!-- Os resultados serão exibidos aqui -->
    </div>
</nav>



    </header>

</body>
</html>