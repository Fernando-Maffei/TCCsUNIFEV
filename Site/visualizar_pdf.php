<?php
// Visualizar PDF
if (isset($_GET['id'])) {
    $tccId = $_GET['id'];

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

    // Consulta SQL para obter o caminho do arquivo PDF
    $sql = "SELECT pdfcaminho FROM documents WHERE id = $tccId";
    $resultado = $conexao->query($sql);

    // Verifica se o resultado da consulta é válido
    if ($resultado->num_rows > 0) {
        $pdfcaminho = $resultado->fetch_assoc()["pdfcaminho"];

        // Exibir a pré-visualização do PDF
        echo '<iframe src="' . $pdfcaminho . '" width="100%" height="800px"></iframe>';

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "ID do TCC não encontrado.";
    }
} else {
    echo "ID do TCC não especificado na URL.";
}
?>
