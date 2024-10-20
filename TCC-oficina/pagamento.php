<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Variável de erro para exibir mensagens
$mensagem = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulação de finalização de pagamento
    $numero_cartao = $_POST['numero_cartao'];
    $nome_cartao = $_POST['nome_cartao'];
    $validade = $_POST['validade'];
    $cvv = $_POST['cvv'];
    $plano = $_POST['plano'];

    // Validações simples de formulário
    if (empty($numero_cartao) || empty($nome_cartao) || empty($validade) || empty($cvv)) {
        $mensagem = "Todos os campos são obrigatórios!";
    } else {
        // Simulação de pagamento bem-sucedido
        $mensagem = "Pagamento realizado com sucesso para o plano: " . htmlspecialchars($plano) . "!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pagamento</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="pagamento-container">
        <h2>Finalizar Pagamento</h2>
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        <form action="pagamento.php" method="POST">
            <label for="plano">Plano Selecionado:</label>
            <select name="plano" id="plano" required>
                <option value="Basico">Básico - R$ 49,90/mês</option>
                <option value="Premium">Premium - R$ 99,90/mês</option>
                <option value="Empresarial">Empresarial - R$ 199,90/mês</option>
            </select>

            <label for="numero_cartao">Número do Cartão:</label>
            <input type="text" name="numero_cartao" maxlength="16" required>

            <label for="nome_cartao">Nome no Cartão:</label>
            <input type="text" name="nome_cartao" required>

            <label for="validade">Validade (MM/AA):</label>
            <input type="text" name="validade" maxlength="5" required>

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" maxlength="3" required>

            <button type="submit">Confirmar Pagamento</button>
        </form>
    </div>
</body>
</html>
