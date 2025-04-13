<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificando se a requisição foi feita via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $nome_completo = $_POST['nome_completo'];
    $nome_empresa = $_POST['nome_empresa'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha

    // SQL para inserir dados na tabela
    $sql = "INSERT INTO cadastro (cpf_cnpj, nome_completo, nome_empresa, telefone, email, senha)
            VALUES ('$cpf_cnpj', '$nome_completo', '$nome_empresa', '$telefone', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Cadastro realizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar: ' . $conn->error]);
    }
    $conn->close();
    exit; // Para garantir que não haverá mais saída de HTML após o AJAX
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro/EasyOfic</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap");

        :root {
            --cor-preta: #000;
            --cor-preto-claro: #151515;
            --cor-branca: #fff;
            --cor-cinza: #808080;
            --azul-real: #2c53d2;
            --cor-roxa: #800080;
            --cinza-medio: #666;
            --cinza-escuro: #333;
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
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        header {
            position: absolute;
            top: -1px;
            display: flex;
            align-items: center;
            height: 80px;
            background-color: black;
            width: 100%;
            z-index: 10;
            padding-left: 30px;
        }

        header > p {
            font-size: 1.9em;
            margin-left: 10px;
            color: #800080;
        }

        #cadastro {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            margin: 20px auto;
            width: 350px;
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
            width: 100%;
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

        .voltar {
            margin-top: 20px;
        }

        .voltar a {
            color: #b6b6b6;
            text-decoration: none;
            font-size: 1em;
        }

        .voltar a:hover {
            color: rgb(83, 231, 83);
        }

        .cadastro {
            font-weight: 600;
            text-transform: uppercase;
            padding-left: 0.2rem;
        }

        .message {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .message.success {
            background-color: rgba(134, 243, 134, 0.8);
            color: black;
            border: 2px solid #4CAF50;
            box-shadow: 0 4px 20px rgba(76, 175, 80, 0.5);
        }

        .message.error {
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            border: 2px solid #F44336;
            box-shadow: 0 4px 20px rgba(244, 67, 54, 0.5);
        }

        @media screen and (max-width: 1024px){
            #cadastro{
                position: relative;
                bottom: 4rem;
            }
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <p id="ia">EASYOFIC</p>
    </header>

    <div id="cadastro">
        <div class="caixa">
            <h1>CADASTRO</h1>
            <form id="formCadastro">
                <div class="cpf_cnpj">
                    <input type="text" name="cpf_cnpj" placeholder="CPF ou CNPJ" required>
                </div>
                <div class="nome_completo">
                    <input type="text" name="nome_completo" placeholder="Nome Completo" required>
                </div>
                <div class="nome_empresa">
                    <input type="text" name="nome_empresa" placeholder="Nome da Empresa" required>
                </div>
                <div class="telefone">
                    <input type="text" name="telefone" placeholder="Telefone" required>
                </div>
                <div class="email">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="senha">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <div class="entrar">
                    <input class="cadastro" type="submit" value="Cadastrar">
                </div>
            </form>
            <div class="message" id="message"></div>
            <div class="voltar">
                <p><a href="login.php">Voltar para Login</a></p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#formCadastro').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '', 
                    data: $(this).serialize() + '&ajax=true',
                    dataType: 'json',
                    success: function(response) {
                        $('#message').removeClass('success error').hide();
                        if (response.status === 'success') {
                            $('#message').addClass('success').text(response.message).fadeIn().delay(3000).fadeOut();
                            $('#formCadastro')[0].reset();
                        } else {
                            $('#message').addClass('error').text(response.message).fadeIn().delay(3000).fadeOut();
                        }
                    },
                    error: function() {
                        $('#message').addClass('error').text('Ocorreu um erro ao enviar os dados.').fadeIn().delay(3000).fadeOut();
                    }
                });
            });
        });
    </script>
</body>
</html>
