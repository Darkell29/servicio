<!DOCTYPE html>
<html>
<head>
    <title>Lavandería Gonzalo - Iniciar Sesión</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        body {
            background-image: url('imagenes/fondo_borroso.png'); /* Reemplaza con la ruta a tu imagen */
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            width: 400px;
            height: auto;
            background-image: linear-gradient(#f7d3e2, #622b7a);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 3px 2px 11px #000;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container h2 {
            text-align: center;
            margin: 20px 0;
            color: #fff;
            font-size: 30px;
        }
        .login-container label {
            margin: 25px 0;
            position: relative;
            width: 100%;
        }
        .login-container label input {
            width: 100%;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0);
            border-style: none;
            outline: none;
            border-bottom: 1px solid #fff;
            color: #fff;
            font-size: 22px;
        }
        .login-container span {
            position: absolute;
            color: #fff;
            top: 50%;
            left: 0;
            font-weight: bold;
            transform: translate(0, -50%);
            transition: 0.2s;
            pointer-events: none; /* Asegura que no se pueda hacer clic en el span */
        }
        label input:focus ~ span,
        label input:valid ~ span {
            font-size: 13px;
            top: -10px; /* Ajusta este valor para mover el texto más arriba */
        }

        .btn {
            width: 110px;
            height: 45px;
            overflow: hidden;
            position: relative;
            margin-top: 20px;
        }
        .btn input[type="submit"] {
            width: 100px;
            position: relative;
            height: 35px;
            font-size: 20px;
            background-color: rgba(255, 255, 255, 0);
            border-style: none;
            color: #622b7a;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }
        .btn:hover input[type="submit"] {
            background-color: #622b7a;
            color: #000;
        }
        .btn .item {
            width: 100px;
            height: 3px;
            position: absolute;
            border-radius: 10%;
            background-image: linear-gradient(90deg, #cc50bd, #441e54);
    transform: translate(112px, 6px);
    animation: btnanimat 3s infinite linear;
}
.btn .item:nth-child(2) {
    transform: translate(-93px, -34px);
    background-image: linear-gradient(90deg, #cc50bd, #441e54);
    animation: btnanimat1 3s infinite linear;
}
.btn .item:nth-child(3) {
    transform: translate(62px, -84px) rotate(90deg);
    background-image: linear-gradient(90deg, #cc50bd, #441e54);
    animation: btnanimat2 3s infinite linear;
}
.btn .item:nth-child(4) {
    transform: translate(-42px, 56px) rotate(-90deg);
    background-image: linear-gradient(90deg, #cc50bd, #441e54);
            animation: btnanimat3 3s infinite linear;
        }
        @keyframes btnanimat1 {
            0% {
                transform: translate(-93px, -34px);
            }
            30% {
                transform: translate(115px, -34px);
            }
            50% {
                transform: translate(115px, -34px);
            }
            75% {
                transform: translate(115px, -34px);
            }
            100% {
                transform: translate(115px, -34px);
            }
        }
        @keyframes btnanimat2 {
            0% {
                transform: translate(55px, -88px) rotate(90deg);
            }
            20% {
                transform: translate(55px, -88px) rotate(90deg);
            }
            55% {
                transform: translate(55px, 56px) rotate(90deg);
            }
            75% {
                transform: translate(55px, 56px) rotate(90deg);
            }
            100% {
                transform: translate(55px, 56px) rotate(90deg);
            }
        }
        @keyframes btnanimat {
            0% {
                transform: translate(112px, 6px);
            }
            25% {
                transform: translate(112px, 6px);
            }
            40% {
                transform: translate(112px, 6px);
            }
            80% {
                transform: translate(-90px, 6px);
            }
            100% {
                transform: translate(-90px, 6px);
            }
        }
        @keyframes btnanimat3 {
            0% {
                transform: translate(-48px, 58px) rotate(-90deg);
            }
            25% {
                transform: translate(-48px, 58px) rotate(-90deg);
            }
            45% {
                transform: translate(-48px, 58px) rotate(-90deg);
            }
            70% {
                transform: translate(-48px, 58px) rotate(-90deg);
            }
            100% {
                transform: translate(-48px, -84px) rotate(-90deg);
            }
        }
        /* Mensaje de error */
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>

        <!-- Mostrar mensajes de error -->
        @if($errors->any())
            <div class="error-message">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <label for="usuario">
                <input type="text" name="usuario" id="usuario" required>
                <span>Usuario<br> <br> <br> <br> </span>
            </label>
            <label for="contraseña">
                <input type="password" name="contraseña" id="contraseña" required>
                <span>Contraseña</span>
            </label>
            <div class="btn">
                <input type="submit" value="Ingresar">
                <div class="item"></div>
                <div class="item"></div>
                <div class="item"></div>
                <div class="item"></div>
            </div>
        </form>
    </div>
</body>
</html>
