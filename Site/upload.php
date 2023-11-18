<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeArquivo = $_FILES["file"]["name"];
    $tipoArquivo = $_FILES["file"]["type"];
    $tamanhoArquivo = $_FILES["file"]["size"];
    $caminhoTemporario = $_FILES["file"]["tmp_name"];


    $conexao = new mysqli("http://127.0.0.1:8050/", "FEZX");

  
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

   
    $dadosArquivo = file_get_contents($caminhoTemporario);
    $dadosArquivo = $conexao->real_escape_string($dadosArquivo);

    
    $inserirArquivo = $conexao->query("INSERT INTO arquivos (nome, mime, dados) VALUES ('$nomeArquivo', '$tipoArquivo', '$dadosArquivo')");

    if ($inserirArquivo) {
        echo "Arquivo enviado com sucesso!";
    } else {
        echo "Erro ao enviar o arquivo: " . $conexao->error;
    }

    $conexao->close();
}
?>
