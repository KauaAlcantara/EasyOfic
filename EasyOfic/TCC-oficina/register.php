<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }
}

$conn->close();
?>
