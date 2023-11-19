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

$docName = $_POST["docName"];
$theme = $_POST["theme"];
$creationDate = $_POST["creationDate"];
$advisor = $_POST["advisor"];
$author = $_POST["author"];
$authorsString = $_POST["authors"];

// Verificar se há uma lista de autores
if (!empty($authorsString)) {
    $authors = explode(',', $authorsString);

    // Manipular o upload do arquivo PDF
    $targetDirectory = "uploads/";
    $targetFile = __DIR__ . '/' . $targetDirectory . basename($_FILES["pdfFile"]["name"]);

    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
        // Caminho do PDF no servidor
        $pdfcaminho = $targetDirectory . basename($_FILES["pdfFile"]["name"]);

        // Inserir dados nas tabelas
        $sqlDoc = "INSERT INTO documents (nome, tema, datacriacao, orientador, pdfcaminho) 
                   VALUES ('$docName', '$theme', '$creationDate', '$advisor', '$pdfcaminho')";
        $conexao->query($sqlDoc);

        $docId = $conexao->insert_id;

        foreach ($authors as $author) {
            $sqlAutor = "INSERT INTO autores (nome) VALUES ('$author')";
            $conexao->query($sqlAutor);

            $autorId = $conexao->insert_id;

            $sqlPalavrasChaves = "INSERT INTO palavraschaves (idpalavra, idtrabalho) VALUES ($autorId, $docId)";
            $conexao->query($sqlPalavrasChaves);
        }

        echo "Documento e autores inseridos com sucesso.";
    } else {
        echo "Erro ao fazer upload do arquivo.";
    }
} elseif (!empty($author)) {
    // Se houver um único autor
    // Manipular o upload do arquivo PDF
    $targetDirectory = "uploads/";
    $targetFile = __DIR__ . '/' . $targetDirectory . basename($_FILES["pdfFile"]["name"]);

    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
        // Caminho do PDF no servidor
        $pdfcaminho = $targetDirectory . basename($_FILES["pdfFile"]["name"]);

        // Inserir dados nas tabelas
        $sqlDoc = "INSERT INTO documents (nome, tema, datacriacao, orientador, pdfcaminho) 
                   VALUES ('$docName', '$theme', '$creationDate', '$advisor', '$pdfcaminho')";
        $conexao->query($sqlDoc);

        $docId = $conexao->insert_id;

        // Inserir o autor único
        $sqlAutor = "INSERT INTO autores (nome) VALUES ('$author')";
        $conexao->query($sqlAutor);

        $autorId = $conexao->insert_id;

        // Associar o autor ao documento
        $sqlPalavrasChaves = "INSERT INTO palavraschaves (idpalavra, idtrabalho) VALUES ($autorId, $docId)";
        $conexao->query($sqlPalavrasChaves);

        echo "Documento e autor inseridos com sucesso.";
    } else {
        echo "Erro ao fazer upload do arquivo.";
    }
} else {
    echo "Por favor, forneça pelo menos um autor.";
}

// Fechar a conexão

$conexao->close();
header("Location: index.html");
exit;

?>
