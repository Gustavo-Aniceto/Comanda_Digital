<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
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
    <div class="header">
        <h1>Cardápio</h1>
    </div>
    <div class="categorias">
        <button class="categoria-btn">Categoria 1</button>
        <button class="categoria-btn">Categoria 2</button>
        <button class="categoria-btn">Categoria 3</button>
        <!-- Adicione mais botões conforme necessário -->
    </div>
</body>
</html>
