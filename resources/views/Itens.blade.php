<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens do Cardápio</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .header {
            background-image: url('restaurant.jpg'); /* Imagem genérica */
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 50px 0;
        }
        .header h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .itens {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .item {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .item:hover {
            transform: translateY(-5px);
        }
        .item img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .item h2 {
            margin-bottom: 5px;
        }
        .item p {
            margin-bottom: 10px;
        }
    </style>

    <div class="header">
        <h1>Itens do Cardápio</h1>
    </div>
    <div class="itens" id="itens">
        <!-- Itens serão adicionados dinamicamente aqui -->
    </div>

    <script>
        // Simulação de itens do cardápio
        var itens = [
            { id: 1, nome: 'Item 1', preco: 10.99, imagem: 'item1.jpg', descricao: 'Descrição do Item 1' },
            { id: 2, nome: 'Item 2', preco: 15.99, imagem: 'item2.jpg', descricao: 'Descrição do Item 2' },
            { id: 3, nome: 'Item 3', preco: 8.99, imagem: 'item3.jpg', descricao: 'Descrição do Item 3' }
        ];

        // Função para listar os itens
        function listarItens(categoria) {
            var container = document.getElementById('itens');
            container.innerHTML = ''; // Limpar conteúdo anterior

            itens.forEach(function(item) {
                var itemHTML = `
                    <div class="item" onclick="mostrarDetalhes(${item.id})">
                        <img src="${item.imagem}" alt="${item.nome}">
                        <h2>${item.nome}</h2>
                        <p>R$ ${item.preco.toFixed(2)}</p>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', itemHTML);
            });
        }

        // Função para mostrar detalhes do item
        function mostrarDetalhes(id) {
            var item = itens.find(function(item) {
                return item.id === id;
            });

            // Redirecionar para a página de detalhes do item
            window.location.href = 'detalhes-item.php?id=' + id;
        }

        // Inicializar a página com os itens
        listarItens();
    </script>
</body>
</html>
