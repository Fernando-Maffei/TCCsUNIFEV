<?php
// Verifica se o parâmetro 'id' está presente na URL
if (isset($_GET['id'])) {
    // Obtém o ID do TCC a partir da URL
    $tccId = $_GET['id'];

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

    // Consulta SQL para obter o caminho do arquivo PDF
    $sql = "SELECT pdf_path FROM tccs WHERE id = $tccId";
    $resultado = $conexao->query($sql);

    // Verifica se o resultado da consulta é válido
    if ($resultado->num_rows > 0) {
        $pdfPath = $resultado->fetch_assoc()["pdf_path"];

        // Exibir a pré-visualização do PDF
        echo
        // Caminho completo para o arquivo PDF
        $caminhoPDF = __DIR__ . '/' . $pdfPath;

        // Verifica se o arquivo existe
        if (file_exists($caminhoPDF)) {
            // Define o tipo de conteúdo para PDF
            header('Content-Type: application/pdf');

            // Força o download do arquivo PDF
            header('Content-Disposition: inline; filename="' . basename($caminhoPDF) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($caminhoPDF);
        } else {
            echo "Arquivo PDF não encontrado.";
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "ID do TCC não encontrado.";
    }
} else {
    echo "ID do TCC não especificado na URL.";
}
?>
