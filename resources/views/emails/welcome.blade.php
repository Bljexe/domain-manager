<!DOCTYPE html>
<html>

<head>
    <title>Bem-vindo!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #007BFF;
        }

        p {
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bem-vindo, {{ $user->name }}!</h1>
        <p>Obrigado por se registrar em nosso site. Estamos felizes em tê-lo conosco.</p>
        <p>Se você tiver alguma dúvida, não hesite em nos contatar.</p>
        <p>Atenciosamente,</p>
        <p>Equipe {{ config('app.name') }}</p>
    </div>
</body>

</html>
