<!-- Inicio.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
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
            background-image: url('restaurant.jpg'); /* Imagem qualquer */
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
        .categorias {
            text-align: center;
            margin-top: 20px;
        }
        .categoria-btn {
            padding: 10px 20px;
            font-size: 1.2em;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .categoria-btn:hover {
            background-color: #0056b3;
        }
    </style>

</head>
<body>
    
    <div class="categorias" id="categorias">
        <!-- Aqui exibidas categorias -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ao carregar a página, listar as categorias
            $.ajax({
                url: '/listar-categorias', // Rota que lista as categorias
                type: 'GET',
                success: function(response) {
                    // Exibir as categorias na página
                    response.forEach(function(categoria) {
                        $('#categorias').append('<button class="categoria-btn" onclick="listarItens(\'' + categoria.nome + '\')">' + categoria.nome + '</button>');
                    });
                },
                error: function(xhr, status, error) {
                    // Lidar com erros, se necessário
                    console.error(error);
                }
            });
        });

        // Função para listar itens de uma categoria específica
        function listarItens(categoria) {
            


            
        }
    </script>
</body>
</html>
