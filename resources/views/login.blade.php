<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('imagenes/fondo_borroso.png'); /* Reemplaza con la ruta a tu imagen */
            background-size: cover;
            background-position: center;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
            width: 25%;
            height: 60%;
        }
        .login-container h2 {
            margin-bottom: 30px;
        }
        .login-container input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
        }
        .login-container button {
            width: 80%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            color: #FFF;
            background-color: #009688;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <input type="text" id="username" placeholder="Usuario">
        <input type="password" id="password" placeholder="Contraseña">
        <button onclick="login()">Ingresar</button>
    </div>
    <script>
        function login() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            if ((username === 'administrador' && password === 'admin') || (username === 'vendedor' && password === 'vende')) {
                window.location.href = 'venta.html?user=' + (username === 'administrador' ? 'admin' : 'vendedor');
            } else {
                alert('Usuario o contraseña incorrectos');
            }
        }
    </script>
</body>
</html>
