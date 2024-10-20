<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

echo "<h1>Bem-vindo, " . $_SESSION['email'] . "!</h1>";
echo "<p>Você está logado no sistema EasyOfic.</p>";
?>

<a href="logout.php">Logout</a>
