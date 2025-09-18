<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>403 - Acesso Negado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }

        .container {
            text-align: center;
            max-width: 500px;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        h1 {
            font-size: 5rem;
            margin: 0;
            color: #e74c3c;
        }

        h2 {
            font-size: 1.5rem;
            margin: 10px 0;
            font-weight: 600;
        }

        p {
            font-size: 1rem;
            margin: 15px 0 25px;
            color: #555;
        }

        a.button {
            display: inline-block;
            padding: 12px 24px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        a.button:hover {
            background: #2980b9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            background-image: url('<?php echo assetfolder ?>assets/media/auth/bg1-dark.jpg');
        }

        [data-theme="dark"] body {
            background-image: url('<?php echo assetfolder ?>assets/media/auth/bg1-dark.jpg');
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>403</h1>
        <h2>Acesso Negado</h2>
        <p>Seu IP não tem permissão para acessar esta aplicação.
    </div>
</body>

</html>