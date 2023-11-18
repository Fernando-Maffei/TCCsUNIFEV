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
