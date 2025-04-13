<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Cadastro de Cliente
if (isset($_POST['cadastrar_cliente'])) {
    $nome = $_POST['nome_cliente'];
    $email = $_POST['email_cliente'];
    $telefone = $_POST['telefone_cliente'];
    $endereco = $_POST['endereco_cliente'];

    $sql = "INSERT INTO clientes (nome, email, telefone, endereco) VALUES ('$nome', '$email', '$telefone', '$endereco')";
    if ($conn->query($sql) === TRUE) {
        header("Location: cadastrar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Cadastro de Veículo
if (isset($_POST['cadastrar_veiculo'])) {
    $cliente_id = $_POST['cliente_id'];
    $marca = $_POST['marca_veiculo'];
    $modelo = $_POST['modelo_veiculo'];
    $ano = $_POST['ano_veiculo'];
    $placa = $_POST['placa_veiculo'];

    $sql = "INSERT INTO veiculos (id_cliente, marca, modelo, ano, placa) VALUES ('$cliente_id', '$marca', '$modelo', '$ano', '$placa')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Cadastro de Fornecedor
if (isset($_POST['cadastrar_fornecedor'])) {
    $nome = $_POST['nome_fornecedor'];
    $contato = $_POST['contato_fornecedor'];
    $telefone = $_POST['telefone_fornecedor'];

    $sql = "INSERT INTO fornecedores (nome, contato, telefone) VALUES ('$nome', '$contato', '$telefone')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Cadastro de Peça
if (isset($_POST['cadastrar_peca'])) {
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $preco = isset($_POST['preco']) ? $_POST['preco'] : null;
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : null;
    $data_cadastro = date('Y-m-d');

    if ($descricao && $preco && $quantidade) {
        $sql = "INSERT INTO pecas (descricao, quantidade, preco, data_cadastro) VALUES ('$descricao', '$quantidade', '$preco', '$data_cadastro')";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Erro ao cadastrar peça: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha todos os campos!";
    }
}

// Cadastro de Orçamento
if (isset($_POST['cadastrar_orcamento'])) {
    $cliente_id_orcamento = $_POST['cliente_id_orcamento'] ?? null;
    $valor_orcamento = $_POST['valor_orcamento'] ?? null;
    $descricao_orcamento = $_POST['descricao_orcamento'] ?? null;

    if ($cliente_id_orcamento && $valor_orcamento && $descricao_orcamento) {
        $query = "INSERT INTO orcamentos (cliente_id_orcamento, valor_orcamento, descricao_orcamento) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ids", $cliente_id_orcamento, $valor_orcamento, $descricao_orcamento);
            if ($stmt->execute()) {
                header("Location: cadastrar.php?msg=sucesso");
                exit();
            } else {
                echo "Erro ao cadastrar orçamento: " . $stmt->error;
            }
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios!";
    }
}

// Cadastro de Funcionário
if (isset($_POST['cadastrar_funcionario'])) {
    $nome = $_POST['nome_funcionario'];
    $cargo = $_POST['cargo_funcionario'];
    $telefone = $_POST['telefone_funcionario'];
    $salario = $_POST['salario_funcionario'];

    $sql = "INSERT INTO funcionarios (nome, cargo, telefone, salario) VALUES ('$nome', '$cargo', '$telefone', '$salario')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: cadastrar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Cadastro de Serviço
if (isset($_POST['cadastrar_servico'])) {
    $descricao = $_POST['descricao_servico'];
    $preco = $_POST['preco_servico'];

    $sql = "INSERT INTO servicos (descricao, preco) VALUES ('$descricao', '$preco')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro-EASYOFIC</title>
    <script>
        function openTab(event, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.className += " active";
        }

        window.onload = function() {
            document.getElementById("defaultOpen").click();
        }
    </script>
</head>
<body>

    <a class="link2" href="peca.php" target=”_blank”>Estoque de peças</a>
    <a class="link" href="visualizar.php" target="_blank">Painel com os dados</a>

<div class="main-container">

    <div class="sidebar">
        <div class="tabs">
            <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Clientes')">Clientes</button>
            <button class="tablinks" onclick="openTab(event, 'Veiculos')">Veículos</button>
            <button class="tablinks" onclick="openTab(event, 'Fornecedores')">Fornecedores</button>
            <button class="tablinks" onclick="openTab(event, 'Pecas')">Peças</button>
            <button class="tablinks" onclick="openTab(event, 'Orcamentos')">Orçamentos</button>
            <button class="tablinks" onclick="openTab(event, 'Funcionarios')">Funcionários</button>
            <button class="tablinks" onclick="openTab(event, 'Servicos')">Serviços</button>
        </div>
    </div>

    <div class="content-area">
        <div id="Clientes" class="tabcontent">
            <h2>Cadastro de Cliente</h2>
            <form action="cadastrar.php" method="POST">
                <label for="nome_cliente">Nome:</label>
                <input type="text" name="nome_cliente" required>

                <label for="email_cliente">Email:</label>
                <input type="email" name="email_cliente" required>

                <label for="telefone_cliente">Telefone:</label>
                <input type="tel" name="telefone_cliente" required>

                <label for="endereco_cliente">Endereço:</label>
                <input type="text" name="endereco_cliente" required>

                <button type="submit" name="cadastrar_cliente">Cadastrar Cliente</button>
            </form>
        </div>

        <div id="Veiculos" class="tabcontent">
            <h2>Cadastro de Veículo</h2>
            <form action="cadastrar.php" method="POST">
                <label for="cliente_id">ID do Cliente:</label>
                <input type="number" name="cliente_id" required>

                <label for="marca_veiculo">Marca:</label>
                <input type="text" name="marca_veiculo" required>

                <label for="modelo_veiculo">Modelo:</label>
                <input type="text" name="modelo_veiculo" required>

                <label for="ano_veiculo">Ano:</label>
                <input type="number" name="ano_veiculo" required>

                <label for="placa_veiculo">Placa:</label>
                <input type="text" name="placa_veiculo" required>

                <button type="submit" name="cadastrar_veiculo">Cadastrar Veículo</button>
            </form>
        </div>

        <div id="Fornecedores" class="tabcontent">
            <h2>Cadastro de Fornecedor</h2>
            <form action="cadastrar.php" method="POST">
                <label for="nome_fornecedor">Nome:</label>
                <input type="text" name="nome_fornecedor" required>

                <label for="contato_fornecedor">Contato:</label>
                <input type="text" name="contato_fornecedor" required>

                <label for="telefone_fornecedor">Telefone:</label>
                <input type="tel" name="telefone_fornecedor" required>

                <button type="submit" name="cadastrar_fornecedor">Cadastrar Fornecedor</button>
            </form>
        </div>

        <div id="Pecas" class="tabcontent">
            <h2>Cadastro de Peça</h2>
            <form action="cadastrar.php" method="POST">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" required>

                <label for="preco">Preço:</label>
                <input type="number" name="preco" step="0.01" required>

                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade" required>

                <button type="submit" name="cadastrar_peca">Cadastrar Peça</button>
            </form>
        </div>

        <div id="Orcamentos" class="tabcontent">
            <h2>Cadastro de Orçamento</h2>
            <form action="cadastrar.php" method="POST">
                <label for="cliente_id_orcamento">ID do Cliente:</label>
                <input type="number" name="cliente_id_orcamento" required>

                <label for="valor_orcamento">Valor:</label>
                <input type="number" name="valor_orcamento" step="0.01" required>

                <label for="descricao_orcamento">Descrição:</label>
                <input type="text" name="descricao_orcamento" required>

                <button type="submit" name="cadastrar_orcamento">Cadastrar Orçamento</button>
            </form>
        </div>

        <div id="Funcionarios" class="tabcontent">
            <h2>Cadastro de Funcionário</h2>
            <form action="cadastrar.php" method="POST">
                <label for="nome_funcionario">Nome:</label>
                <input type="text" name="nome_funcionario" required>

                <label for="cargo_funcionario">Cargo:</label>
                <input type="text" name="cargo_funcionario" required>

                <label for="telefone_funcionario">Telefone:</label>
                <input type="tel" name="telefone_funcionario" required>

                <label for="salario_funcionario">Salário:</label>
                <input type="number" name="salario_funcionario" step="0.01" required>

                <button type="submit" name="cadastrar_funcionario">Cadastrar Funcionário</button>
            </form>
        </div>

        <div id="Servicos" class="tabcontent">
            <h2>Cadastro de Serviço</h2>
            <form action="cadastrar.php" method="POST">

                <label for="descricao_servico">Descrição:</label>
                <input type="text" name="descricao_servico" required>

                <label for="preco_servico">Preço:</label>
                <input type="number" name="preco_servico" step="0.01" required>

                <button type="submit" name="cadastrar_servico">Cadastrar Serviço</button>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso') {
    echo '<div class="alert">Cadastro realizado com sucesso!</div>';
}
?>

<style>
        /* Estilo Geral */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            height: 100vh; /* Ocupa toda a altura da janela */
        }

        .main-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 80vh;
            margin: auto;
            margin-right: 10rem;
            background-color: #fff;
            border-radius: 25px; /* Bordas mais arredondadas */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Sombra mais suave */
        }

        /* Sidebar com Abas Horizontais */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding: 10px 0;
            border-radius: 25px 0 0 25px; /* Bordas arredondadas à esquerda */
            display: flex;
            flex-direction: column;
        }

        .tabs {
            display: flex;
            flex-direction: column;
        }

        .tabs button {
            padding: 15px;
            width: 100%;
            background: none;
            color: #ecf0f1;
            text-align: left;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0; /* Remove bordas arredondadas das abas */
        }

        .tabs button:hover, .tabs button.active {
            background-color: #34495e;
        }

        .tabs button.active {
            background-color: #007bff;
            color: white;
        }

        /* Área de Conteúdo */
        .content-area {
            flex-grow: 1;
            padding: 30px;
            background-color: #f7f9fc;
            border-radius: 0 25px 25px 0; /* Bordas arredondadas à direita */
            overflow-y: auto;
        }

        .tabcontent {
            display: none;
            animation: fadeEffect 0.5s ease;
        }

        h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Formulário */
        form {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px; /* Bordas arredondadas do formulário */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Espaço entre o título e o formulário */
        }

        label {
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="tel"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px; /* Bordas arredondadas nos campos */
            font-size: 16px;
            margin-bottom: 15px;
            transition: border 0.3s;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 10px; /* Bordas arredondadas no botão */
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Animação para transição suave */
        @keyframes fadeEffect {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        .link {
            position: absolute;
            top: 2rem;
            left: 34rem;
            text-decoration: none;
            color: #34495e;
            white-space: nowrap;
            font-size: 18px;
        }
        
        .link2{
           position: absolute;
           top: 2rem;
           left: 50rem;
           text-decoration: none;
           color: #34495e;
           white-space: nowrap;
           font-size: 18px; 
        }

        @media screen and (max-width: 1024px) {

        .main-container{
            width: 100vh;
            font-size: 15px;
            position: relative;
            bottom: 2rem;
            left: 2rem;
        }

        .link, .link2 {
        position: fixed;
        top: 1rem;
        font-size: 16px;
        white-space: nowrap;
        }   

        .link {
        left: 2rem;
        }

        .link2 {
        left: 15rem;
        }
        
        .tablinks{
           margin-left: 7rem;
           font-size: 1px;
        }
    
    }

    </style>
</body>
</html>
