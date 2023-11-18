<?php
$host = "localhost";  // Altere para o host do seu banco de dados (pode ser localhost)
$usuario = "root";    // Altere para o usuário do seu banco de dados
$senha = "";          // Altere para a senha do seu banco de dados
$banco = "mydatabase"; // Altere para o nome do seu banco de dados

// Conectar ao banco de dados
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}
?>
