<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Beneficiários</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .lista {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .item {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item strong {
            display: inline-block;
            width: 140px;
        }

        /* Botão flutuante */
        .btn-add {
            position: fixed;
            right: 25px;
            bottom: 25px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 30px;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }

        .btn-add:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Beneficiários</h1>

    <div class="lista">

        <div class="item">
            <strong>Nome grupo:</strong> Grupo Alfa <br>
            <strong>Valor:</strong> R$ 5.000,00 <br>
            <strong>Setor:</strong> Saúde
        </div>

        <div class="item">
            <strong>Nome grupo:</strong> Grupo Beta <br>
            <strong>Valor:</strong> R$ 3.200,00 <br>
            <strong>Setor:</strong> Educação
        </div>

        <div class="item">
            <strong>Nome grupo:</strong> Grupo Gama <br>
            <strong>Valor:</strong> R$ 8.750,00 <br>
            <strong>Setor:</strong> Tecnologia
        </div>

    </div>

    <button class="btn-add">+</button>

</body>
</html>

