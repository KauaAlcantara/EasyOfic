<?php
// Inicia a sessão
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Mensagens de feedback
$msg = '';
$msg_retirada = '';

// Função de exclusão de peça
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir']) && isset($_POST['id'])) {
    $id_excluir = intval($_POST['id']); // Obtém o ID a ser excluído

    // Exclui a peça do banco de dados
    $sql = "DELETE FROM pecas WHERE id = $id_excluir";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Peça excluída com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir a peça: " . $conn->error;
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio de formulário
    exit();
}

// Retirar peças
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['retirar']) && isset($_POST['id_retirar']) && isset($_POST['quantidade'])) {
    $id_retirar = intval($_POST['id_retirar']);
    $quantidade_retirar = intval($_POST['quantidade']);

    // Verifica se a quantidade a ser retirada é válida
    $sql = "SELECT quantidade FROM pecas WHERE id = $id_retirar";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row && $row['quantidade'] >= $quantidade_retirar) {
        // Atualiza a quantidade no banco de dados
        $nova_quantidade = $row['quantidade'] - $quantidade_retirar;
        $sql_update = "UPDATE pecas SET quantidade = $nova_quantidade WHERE id = $id_retirar";
        
        if ($conn->query($sql_update) === TRUE) {
            $_SESSION['msg_retirada'] = "Retirada de $quantidade_retirar peça(s) realizada com sucesso!";
        } else {
            $_SESSION['msg_retirada'] = "Erro ao retirar as peças: " . $conn->error;
        }
    } else {
        $_SESSION['msg_retirada'] = "Quantidade insuficiente em estoque.";
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio de formulário
    exit();
}

// Lógica de pesquisa
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

$sql = "SELECT id, descricao, quantidade, preco, data_cadastro FROM pecas";
if ($search_query) {
    $sql .= " WHERE descricao LIKE '%" . $conn->real_escape_string($search_query) . "%'";
}
$result = $conn->query($sql);

// Variáveis para armazenar o total de peças e o valor total do estoque
$total_quantidade = 0;
$valor_total_estoque = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque de Peças</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 50%; /* Reduz a largura para 50% */
            max-width: 300px; /* Define uma largura máxima */
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .price {
            color: #28a745;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .summary {
            text-align: right;
            font-size: 16px;
            margin-top: 30px;
            color: #555;
        }

        .summary p {
            margin: 5px 0;
        }

        .summary span {
            font-weight: bold;
            color: #333;
        }

        .retirar-container {
            display: flex;
            justify-content: center;
        }

        .retirar-container input {
            width: 60px;
            padding: 5px;
            margin-right: 10px;
        }

        .retirar-button {
            background-color: #ff4d4d;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .retirar-button:hover {
            background-color: #ff1a1a;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        @media screen and (max-width: 1024px) {
            .container {
                width: 100%;
                position: relative;
                bottom: 5rem;
                font-size: 14px;
            }

            table th {
                text-align: right;
                background-color: transparent;
                padding: 5px 5px;
                color: #007bff;
                border: none;
                font-size: 13px;
            }

            table td {
                text-align: left;
                padding: 0px;
                border: none;
                position: relative;
                font-size: 13px;
            }

            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                font-weight: bold;
                color: #333;
            }

            .summary {
                text-align: center;
            }

            .retirar-container {
                flex-direction: column;
                align-items: center;
                margin-left: 20px;
            }

            .retirar-container input {
                margin-bottom: 10px;
                margin-left: 2px;
                width: 11px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Estoque de Peças</h1>

        <!-- Barra de pesquisa -->
        <div class="search-container">
            <form method="post">
                <input type="text" name="search" placeholder="Pesquisar peça..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Pesquisar</button>
            </form>
        </div>

        <!-- Mensagem de feedback para exclusão -->
        <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-center" style="color: green; font-weight: bold;"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></p>
        <?php endif; ?>

        <!-- Mensagem de feedback para retirada -->
        <?php if (isset($_SESSION['msg_retirada'])): ?>
            <p class="text-center" style="color: blue; font-weight: bold;"><?php echo $_SESSION['msg_retirada']; unset($_SESSION['msg_retirada']); ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Data de Cadastro</th>
                        <th>Retirar Peças</th>
                        <th>Excluir Peças</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        // Calcula o valor total do estoque e a quantidade total
                        $total_quantidade += $row['quantidade'];
                        $valor_total_estoque += $row['quantidade'] * $row['preco'];
                    ?>
                        <tr>
                            <td><?php echo $row['descricao']; ?></td>
                            <td class="text-center"><?php echo $row['quantidade']; ?></td>
                            <td class="price">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_cadastro'])); ?></td>
                            <td>
                                <div class="retirar-container">
                                    <input type="number" id="retirar-<?php echo $row['id']; ?>" min="1" max="<?php echo $row['quantidade']; ?>" value="1">
                                    <button class="retirar-button" onclick="retirarPecas(<?php echo $row['id']; ?>)">Retirar</button>
                                </div>
                            </td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="excluir" class="delete-button">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="summary">
                <p><span>Total de Peças no Estoque:</span> <?php echo $total_quantidade; ?></p>
                <p><span>Valor Total do Estoque:</span> R$ <?php echo number_format($valor_total_estoque, 2, ',', '.'); ?></p>
            </div>
        <?php else: ?>
            <p class="text-center">Nenhuma peça cadastrada no estoque.</p>
        <?php endif; ?>

        <div class="footer">
            &copy; <?php echo date('Y'); ?> EasyOfic. Todos os direitos reservados.
        </div>
    </div>

    <script>
        function retirarPecas(id) {
            var quantidade = document.getElementById('retirar-' + id).value;

            $.post("peca.php", { id_retirar: id, quantidade: quantidade, retirar: true }, function(response) {
                // Atualiza a mensagem de feedback na página
                $('.container').prepend('<p class="text-center" style="color: blue; font-weight: bold;">' + response + '</p>');
                location.reload(); // Recarrega a página para mostrar as alterações
            });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
