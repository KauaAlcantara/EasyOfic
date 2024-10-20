<?php
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    switch ($type) {
        case 'clientes':
            $sql = "DELETE FROM clientes WHERE id = $id";
            break;
        case 'veiculos':
            $sql = "DELETE FROM veiculos WHERE id = $id";
            break;
        case 'fornecedores':
            $sql = "DELETE FROM fornecedores WHERE id = $id";
            break;
        case 'orcamentos':
            $sql = "DELETE FROM orcamentos WHERE id = $id";
            break;
        case 'funcionarios':
            $sql = "DELETE FROM funcionarios WHERE id = $id";
            break;
        case 'servicos':
            $sql = "DELETE FROM servicos WHERE id = $id";
            break;
        default:
            echo "Tipo inválido.";
            exit;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Registro excluído com sucesso.";
    } else {
        echo "Erro ao excluir registro: " . $conn->error;
    }
} else {
    echo "Dados não recebidos.";
}

$conn->close();
?>
