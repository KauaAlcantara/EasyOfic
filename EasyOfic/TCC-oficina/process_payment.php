<?php
// process_payment.php

function processCreditCardPayment($cardNumber, $cardName, $expiryDate, $cvv) {
    return true; // Simular sucesso (alterar para false para testar erro)
}

function processPixPayment() {
    return true; // Simular sucesso (alterar para false para testar erro)
}

if (isset($_POST['payment_method'])) {
    $paymentMethod = $_POST['payment_method'];

    if ($paymentMethod == 'credit_card') {
        $cardNumber = $_POST['card_number'] ?? '';
        $cardName = $_POST['card_name'] ?? '';
        $expiryDate = $_POST['expiry_date'] ?? '';
        $cvv = $_POST['cvv'] ?? '';

        if (empty($cardNumber) || empty($cardName) || empty($expiryDate) || empty($cvv)) {
            header("Location: error.php");
            exit;
        }

        $isPaymentSuccessful = processCreditCardPayment($cardNumber, $cardName, $expiryDate, $cvv);

        if ($isPaymentSuccessful) {
            header("Location: success.php");
            exit;
        } else {
            header("Location: error.php");
            exit;
        }
    } elseif ($paymentMethod == 'pix') {
        $isPaymentSuccessful = processPixPayment();

        if ($isPaymentSuccessful) {
            header("Location: success.php");
            exit;
        } else {
            header("Location: error.php");
            exit;
        }
    } else {
        header("Location: error.php");
        exit;
    }
} else {
    header("Location: error.php");
    exit;
}
