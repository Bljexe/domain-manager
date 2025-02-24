<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            overflow: hidden;
            position: relative;
        }

        .background-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .bubble {
            position: absolute;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 5s infinite ease-in-out;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-control {
            padding-right: 2.5rem;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="background-animation">
        <div class="bubble" style="top: 10%; left: 20%;"></div>
        <div class="bubble" style="top: 30%; left: 70%; width: 60px; height: 60px;"></div>
        <div class="bubble" style="top: 50%; left: 40%; width: 50px; height: 50px;"></div>
        <div class="bubble" style="top: 80%; left: 60%; width: 70px; height: 70px;"></div>
    </div>

    <div class="login-container">
        <h3 class="mb-3">Login</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 text-start position-relative">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    👁️
                </span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <div class="mt-3">
            <a href="{{ route('forgot-password') }}" class="text-decoration-none">Esqueceu sua senha?</a> |
            <a href="{{ route('register') }}" class="text-decoration-none">Registrar</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    var notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top',
        }
    });

    @if (session('success'))
        notyf.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        notyf.error("{{ session('error') }}");
    @endif
</script>

</html>
