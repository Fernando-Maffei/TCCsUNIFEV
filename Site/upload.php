<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configurações de conexão com o banco de dados
    $host = "localhost";  // Altere para o host do seu banco de dados
    $usuario = "root";    // Altere para o usuário do seu banco de dados
    $senha = "";          // Altere para a senha do seu banco de dados
    $banco = "RepositorioTCC"; // Altere para o nome do seu banco de dados

    // Conectar ao banco de dados
    $conexao = new mysqli($host, $usuario, $senha, $banco);

    // Verificar a conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Obter dados do formulário
    $title = $_POST["title"];
    $preview = $_POST["preview"];

    // Manipular o upload do arquivo PDF
    $targetDirectory = "/uploads";  // Diretório onde os arquivos serão armazenados
    $targetFile = __DIR__ . '/' . $targetDirectory . basename($_FILES["pdfFile"]["name"]);

    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
        // Caminho do PDF no servidor
        $pdfPath = $targetFile;

        // Inserir dados no banco de dados
        $sql = "INSERT INTO tccs (title, preview, pdf_path) VALUES ('$title', '$preview', '$pdfPath')";
        if ($conexao->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso.";
        } else {
            echo "Erro ao inserir dados: " . $conexao->error;
        }
    } else {
        echo "Erro ao fazer upload do arquivo.";
    }

    // Fechar a conexão
    $conexao->close();
}
header("Location: index.html");
exit; // Certifique-se de parar a execução do script após o redirecionamento
?>
