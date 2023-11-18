<?php
// Função para realizar a pesquisa no banco de dados
function searchTCC($searchCriteria, $searchTerm) {
    // Configurações de conexão com o banco de dados
    $host = "localhost";  // Altere para o host do seu banco de dados
    $usuario = "root";    // Altere para o usuário do seu banco de dados
    $senha = "";          // Altere para a senha do seu banco de dados
    $banco = "seu_banco"; // Altere para o nome do seu banco de dados

    // Conectar ao banco de dados
    $conexao = new mysqli($host, $usuario, $senha, $banco);

    // Verificar a conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Consulta SQL para buscar TCCs com base nos critérios de pesquisa
    $sql = "SELECT title, preview FROM tccs WHERE $searchCriteria LIKE '%$searchTerm%'";
    $resultado = $conexao->query($sql);

    // Exibir os resultados
    displayResults($resultado);

    // Fechar a conexão
    $conexao->close();
}

// Função para exibir os resultados
function displayResults($results) {
    $resultsContainer = '<div id="searchResults"></div>';

    if ($results->num_rows === 0) {
        $resultsContainer .= 'Nenhum resultado encontrado.';
    } else {
        while ($result = $results->fetch_assoc()) {
            $resultElement = '<div>';
            $resultElement .= '<h3>' . $result["title"] . '</h3>';
            $resultElement .= '<p>' . $result["autor"] . '</p>';
            $resultElement .= '</div>';
            $resultsContainer .= $resultElement;
        }
    }

    echo $resultsContainer;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchCriteria = $_POST["searchCriteria"];
    $searchTerm = $_POST["searchInput"];
    searchTCC($searchCriteria, $searchTerm);
}
?>
