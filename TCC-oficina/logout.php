<?php
session_start();
session_destroy(); // Destroi todas as informações da sessão
header("Location: index.html"); // Redireciona para a página principal após o logout
exit();
?>
