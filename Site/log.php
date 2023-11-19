<?php
// Credenciais do banco de dados
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tcc_database";

// Criar uma conexão
$conn = new mysqli($hostname, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "Conexão bem-sucedida";


if(isset($_POST['submit']) && !empty($_POST['usuario']) && !empty($_POST['senha'])) {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' and senha = '$senha'";

    $_result = $conn->query($sql);

    print_r($_result);

        if($conn->affected_rows < 1) {
            header('Location: log.html');
        }else {

            header('Location: upload.html');
        }
    }
else{

    header('Location: log.html');

}


// Fecha a conexão
$conn->close();
?>