<?php
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantidade = $_POST['quantidade'];

    // Verificar quantidade atual
    $sql = "SELECT quantidade, preco FROM pecas WHERE id = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantidadeAtual = $row['quantidade'];
        $precoAtual = $row['preco'];

        if ($quantidade > $quantidadeAtual) {
            echo "Erro: Quantidade solicitada excede o estoque.";
        } else {
            // Atualizar quantidade no estoque
            $novaQuantidade = $quantidadeAtual - $quantidade;
            
            // Se a quantidade chegar a zero, resetar o preço para 0
            if ($novaQuantidade == 0) {
                $novoPreco = 0.00;
            } else {
                $novoPreco = $precoAtual;
            }

            $sqlUpdate = "UPDATE pecas SET quantidade = $novaQuantidade, preco = $novoPreco WHERE id = $id";
            if ($conn->query($sqlUpdate) === TRUE) {
                echo "Peças retiradas com sucesso. Preço resetado se o estoque chegou a zero.";
            } else {
                echo "Erro ao retirar peças: " . $conn->error;
            }
        }
    } else {
        echo "Peça não encontrada.";
    }
}

$conn->close();
?>
