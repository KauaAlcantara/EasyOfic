<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'easyofic');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Dados</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .main-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 80vh;
            margin: auto;
            margin-top: 5rem;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding: 10px 0;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
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
        }

        .tabs button:hover, .tabs button.active {
            background-color: #34495e;
        }

        .tabs button.active {
            background-color: #007bff;
            color: white;
        }

        .content-area {
            flex-grow: 1;
            padding: 30px;
            background-color: #f7f9fc;
            overflow-y: auto;
        }

        h2 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        .data-container {
            margin-top: 20px;
        }

        .data-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            position: relative;
            width: calc(90% - 20px);
            margin: 0 auto;
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .data-label {
            font-weight: bold;
            color: #007bff;
            text-transform: uppercase;
        }

        .data-value {
            color: #333;
            width: 70%;
        }

        .delete-button {
            position: absolute;
            right: 15px;
            top: 15px;
            background-color: transparent;
            color: #e74c3c;
            border: none;
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s;
        }

        .delete-button img {
            width: 24px;
            height: 24px;
        }

        .delete-button:hover {
            color: #c0392b;
        }

        input[type="text"] {
            width: 30%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #007bff;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #0056b3;
        }

        @media screen and (max-width: 1024px){

    
            .main-container{
                position: relative;
                height: 30rem;
                font-size: 14px;
            }

            .data-item{
                width: 20rem;
                position: relative;
                right: 1rem;
            }

        
            .tabs button{
                font-size: 16px;
            }
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="main-container">
    <div class="sidebar">
        <div class="tabs">
            <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Clientes')">Clientes</button>
            <button class="tablinks" onclick="openTab(event, 'Veiculos')">Veículos</button>
            <button class="tablinks" onclick="openTab(event, 'Fornecedores')">Fornecedores</button>
            <button class="tablinks" onclick="openTab(event, 'Orcamentos')">Orçamentos</button>
            <button class="tablinks" onclick="openTab(event, 'Funcionarios')">Funcionários</button>
            <button class="tablinks" onclick="openTab(event, 'Servicos')">Serviços</button>
        </div>
    </div>

    <div class="content-area">
        <div id="Clientes" class="tabcontent">
            <h2>Clientes</h2>
            <input type="text" id="searchClientes" onkeyup="filterData('Clientes')" placeholder="Pesquisar Clientes..." />
            <div class="data-container" id="dataClientes">
                <?php
                $sql = "SELECT * FROM clientes";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"clientes\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                                <div class='data-row'>
                                    <div class='data-label'>ID:</div>
                                    <div class='data-value'>{$row['id']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Nome:</div>
                                    <div class='data-value'>{$row['nome']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Email:</div>
                                    <div class='data-value'>{$row['email']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Telefone:</div>
                                    <div class='data-value'>{$row['telefone']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Endereço:</div>
                                    <div class='data-value'>{$row['endereco']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum cliente cadastrado.</div>";
                }
                ?>
            </div>
        </div>

        <div id="Veiculos" class="tabcontent">
            <h2>Veículos</h2>
            <input type="text" id="searchVeiculos" onkeyup="filterData('Veiculos')" placeholder="Pesquisar Veículos..." />
            <div class="data-container" id="dataVeiculos">
                <?php
                $sql = "SELECT * FROM veiculos";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"veiculos\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                                <div class='data-row'>
                                    <div class='data-label'>ID:</div>
                                    <div class='data-value'>{$row['id']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Marca:</div>
                                    <div class='data-value'>{$row['marca']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Modelo:</div>
                                    <div class='data-value'>{$row['modelo']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Ano:</div>
                                    <div class='data-value'>{$row['ano']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Placa:</div>
                                    <div class='data-value'>{$row['placa']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum veículo cadastrado.</div>";
                }
                ?>
            </div>
        </div>

        <div id="Fornecedores" class="tabcontent">
            <h2>Fornecedores</h2>
            <input type="text" id="searchFornecedores" onkeyup="filterData('Fornecedores')" placeholder="Pesquisar Fornecedores..." />
            <div class="data-container" id="dataFornecedores">
                <?php
                $sql = "SELECT * FROM fornecedores";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"fornecedores\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                    
                                <div class='data-row'>
                                    <div class='data-label'>Nome:</div>
                                    <div class='data-value'>{$row['nome']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Contato:</div>
                                    <div class='data-value'>{$row['contato']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Telefone:</div>
                                    <div class='data-value'>{$row['telefone']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum fornecedor cadastrado.</div>";
                }
                ?>
            </div>
        </div>

        <div id="Orcamentos" class="tabcontent">
            <h2>Orçamentos</h2>
            <input type="text" id="searchOrcamentos" onkeyup="filterData('Orcamentos')" placeholder="Pesquisar Orçamentos..." />
            <div class="data-container" id="dataOrcamentos">
                <?php
                $sql = "SELECT * FROM orcamentos";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"orcamentos\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                                <div class='data-row'>
                                    <div class='data-label'>ID:</div>
                                    <div class='data-value'>{$row['id']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Valor:</div>
                                    <div class='data-value'>{$row['valor_orcamento']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Descrição:</div>
                                    <div class='data-value'>{$row['descricao_orcamento']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum orçamento cadastrado.</div>";
                }
                ?>
            </div>
        </div>

        <div id="Funcionarios" class="tabcontent">
            <h2>Funcionários</h2>
            <input type="text" id="searchFuncionarios" onkeyup="filterData('Funcionarios')" placeholder="Pesquisar Funcionários..." />
            <div class="data-container" id="dataFuncionarios">
                <?php
                $sql = "SELECT * FROM funcionarios";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"funcionarios\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                        
                                <div class='data-row'>
                                    <div class='data-label'>Nome:</div>
                                    <div class='data-value'>{$row['nome']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Cargo:</div>
                                    <div class='data-value'>{$row['cargo']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Telefone:</div>
                                    <div class='data-value'>{$row['telefone']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Salário:</div>
                                    <div class='data-value'>{$row['salario']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum funcionário cadastrado.</div>";
                }
                ?>
            </div>
        </div>

        <div id="Servicos" class="tabcontent">
            <h2>Serviços</h2>
            <input type="text" id="searchServicos" onkeyup="filterData('Servicos')" placeholder="Pesquisar Serviços..." />
            <div class="data-container" id="dataServicos">
                <?php
                $sql = "SELECT * FROM servicos";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='data-item'>
                                <button class='delete-button' onclick='deleteItem({$row['id']}, \"servicos\")'>
                                    <img src='https://img.icons8.com/material-outlined/24/000000/trash.png'/>
                                </button>
                            
                                <div class='data-row'>
                                    <div class='data-label'>Descrição do serviço:</div>
                                    <div class='data-value'>{$row['descricao']}</div>
                                </div>
                                <div class='data-row'>
                                    <div class='data-label'>Preço:</div>
                                    <div class='data-value'>{$row['preco']}</div>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<div class='data-item'>Nenhum serviço cadastrado.</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function openTab(evt, tabName) {
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
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();

    function filterData(tab) {
        var input, filter, container, items, rows, i, txtValue;
        input = document.getElementById("search" + tab);
        filter = input.value.toLowerCase();
        container = document.getElementById("data" + tab);
        items = container.getElementsByClassName("data-item");

        for (i = 0; i < items.length; i++) {
            rows = items[i].getElementsByClassName("data-value");
            let found = false;
            for (let j = 0; j < rows.length; j++) {
                if (rows[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            items[i].style.display = found ? "" : "none";
        }
    }

    function deleteItem(id, type) {
        if (confirm("Tem certeza que deseja excluir este " + type + "?")) {
            $.post("delete.php", { id: id, type: type }, function(response) {
                alert(response);
                location.reload();
            });
        }
    }
</script>

</body>
</html>
