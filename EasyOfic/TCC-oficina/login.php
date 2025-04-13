<?php
// Iniciar a sessão
session_start();
$message = ''; // Variável para armazenar a mensagem de erro ou sucesso

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se os campos não estão vazios
    if (!empty($email) && !empty($senha)) {
        // Consulta o banco para verificar se o email existe
        $sql = "SELECT * FROM cadastro WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Obtém os dados do usuário
            $row = $result->fetch_assoc();
            $senhaHash = $row['senha'];

            // Verifica se a senha corresponde
            if (password_verify($senha, $senhaHash)) {
                // Login bem-sucedido, armazena o ID do usuário na sessão
                $_SESSION['user_id'] = $row['id']; // Altere 'id' para o campo correto do seu banco de dados
                // Redireciona para a tela de cadastro após o login
                header('Location: cadastrar.php');
                exit();
            } else {
                // Senha incorreta
                $message = 'Senha incorreta.';
            }
        } else {
            // E-mail não encontrado
            $message = 'E-mail não encontrado.';
        }
    } else {
        // Verifica se o e-mail ou senha estão vazios
        $message = 'Por favor, preencha todos os campos.';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/EasyOfic</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap");

        :root {
            --montserrat: "Montserrat", sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--montserrat);
            color: white;
            background-image: url('assets/como-modernizar-uma-oficina-mecanica-1.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        header {
            height: 100px;
            background-color: black;
            display: flex;
            align-items: center;
            padding-left: 30px;
        }

        header > p {
            font-size: 1.9em;
            margin-left: 10px;
            color: #800080;
        }

        #login {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 400px;
            flex: 1;
        }

        .caixa {
            margin-top: 20px;
        }

        h1 {
            padding-bottom: 20px;
        }

        input {
            font-family: var(--montserrat);
            border-radius: 15px;
            border: none;
            width: 250px;
            height: 40px;
            padding-left: 15px;
            background-color: #1e1c2e;
            color: #b6b6b6;
            margin-bottom: 15px;
            transition: background-color 0.3s ease;
        }

        input:focus {
            outline: none;
            background-color: #333;
        }

        .login {
            text-transform: uppercase;
            padding-right: 1rem;
            font-weight: 600;
        }

        input::placeholder {
            color: #b6b6b6;
        }

        input[type="submit"] {
            cursor: pointer;
            background-color: rgb(134, 243, 134);
            color: black;
            border-radius: 20px;
            width: 130px;
        }

        input[type="submit"]:hover {
            background-color: rgb(83, 231, 83);
            transform: translateY(-2px);
            transition: transform 0.4s;
        }

        p {
            font-size: 1.3em;
            padding-top: 10px;
            padding-bottom: 20px;
        }

        .cadastrar {
            margin-top: 20px;
            font-size: 15px;
        }

        .cadastrar a {
            color: #b6b6b6;
            text-decoration: none;
            font-size: 1em;
        }

        .cadastrar a:hover {
            color: rgb(83, 231, 83);
        }

        /* Estilo para mensagens de erro ou sucesso */
        .message {
            display: block;
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .message.error {
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            border: 2px solid #F44336; /* Bordas vermelhas */
            box-shadow: 0 4px 20px rgba(244, 67, 54, 0.5);
        }

        .message.success {
            background-color: rgba(134, 243, 134, 0.8);
            color: black;
            border: 2px solid #4CAF50; /* Bordas verdes */
            box-shadow: 0 4px 20px rgba(76, 175, 80, 0.5);
        }

        @media screen and (max-width: 1024px) {
          #login{
            position: relative;
            top: 2rem;
          }  
        }
    </style>
</head>
<body>
    <header>
        <p id="ia">EASYOFIC</p>
    </header>

    <div id="login">
        <div class="caixa">
            <h1>LOGIN</h1>
            <form action="login.php" method="POST">
                <div class="email">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="senha">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <div class="entrar">
                    <input class="login" type="submit" value="Entrar">
                </div>
            </form>

            <!-- Div para exibir mensagens de erro ou sucesso -->
            <?php if (!empty($message)): ?>
                <div class="message error"><?= $message; ?></div>
            <?php endif; ?>

            <div class="cadastrar">
                <p><a href="telaacadastro.php">Não tem uma conta? Cadastre-se</a></p>
            </div>
        </div>
    </div>
</body>
</html>
