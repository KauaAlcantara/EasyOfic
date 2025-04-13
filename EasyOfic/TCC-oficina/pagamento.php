<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        #credit-card-info, #pix-info {
            display: none;
        }
        .qr-code {
            text-align: center;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <script>
        function showPaymentFields() {
            var paymentMethod = document.getElementById("payment-method").value;
            document.getElementById("credit-card-info").style.display = paymentMethod === "credit_card" ? "block" : "none";
            document.getElementById("pix-info").style.display = paymentMethod === "pix" ? "block" : "none";
        }
    </script>
</head>
<body>

<a href="index.html" class="back-link">← Voltar para a página inicial</a>

<div class="container">
    <h2>Pagamento</h2>
    <form action="process_payment.php" method="POST">
        <div class="form-group">
            <label for="payment-method">Método de Pagamento:</label>
            <select id="payment-method" name="payment_method" onchange="showPaymentFields()">
                <option value="" disabled selected>Selecione uma opção</option>
                <option value="credit_card">Cartão de Crédito</option>
                <option value="pix">PIX</option>
            </select>
        </div>

        <div id="credit-card-info">
            <div class="form-group">
                <label for="card-number">Número do Cartão:</label>
                <input type="text" id="card-number" name="card_number" placeholder="Digite o número do cartão">
            </div>
            <div class="form-group">
                <label for="card-name">Nome no Cartão:</label>
                <input type="text" id="card-name" name="card_name" placeholder="Digite o nome no cartão">
            </div>
            <div class="form-group">
                <label for="expiry-date">Data de Validade:</label>
                <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/AA">
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="number" id="cvv" name="cvv" placeholder="CVV">
            </div>
        </div>

        <div id="pix-info">
            <div class="qr-code">
                <p>Escaneie o QR Code para realizar o pagamento:</p>
                <img src="assets/qrcode-pix.png" alt="QR Code do PIX">
                <p style="margin-top: 10px; font-size: 14px; color: #333;">38874c91-b335-4941-a5a1-9a735b2a70ec</p>
            </div>
        </div>

        <button type="submit" class="submit-btn">Pagar</button>
    </form>
</div>

</body>
</html>
