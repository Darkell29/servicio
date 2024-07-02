<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SUPER CLEAN</title>
  <link rel="stylesheet" media="all" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
  <style>
    body {
        overflow: hidden;
        background: rgb(25, 35, 125);
        font-family: 'Chewy', cursive; /* Aplicar la fuente */
    }

    div.drop-container {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        height: 400px; /* Doble de 200px */
        width: 400px; /* Doble de 200px */
    }

    div.drop {
        position: absolute;
        top: -50%; /* Doble de -25% */
        width: 100%;
        height: 100%;
        border-radius: 200% 10% 200% 200%; /* Ajuste proporcional */
        transform: rotate(-45deg);
        margin: 0px;
        background: deepskyblue;
        animation: drip 2s forwards; /* Reducir a 2s */
    }

    h1 {
        color: white;
        position: absolute;
        font-size: 9em; /* Doble de 2.5em */
        height: 2.5em; /* Doble de 1em */
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 2;
        margin: auto;
        text-align: center;
        opacity: 0;
        animation: appear 1s 1.5s forwards; /* Reducir a 1s y retraso a 1.5s */
    }

    @keyframes appear {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    div.drop-container:before,
    div.drop-container:after {
        content: '';
        position: absolute;
        z-index: -1;
        top: 55%;
        right: 50%;
        transform: translate(50%) rotateX(75deg);
        border-radius: 100%;
        opacity: 0;
        width: 150%;
        height: 150%;
        border: 10px solid skyblue;
        animation: dripple 1.5s ease-out 0.5s; /* Reducir a 1s y retraso a 0.5s */
    }

    div.drop-container:after {
        animation: dripple 1.5s ease-out 0.85s; /* Reducir a 1s y retraso a 0.85s */
    }

    @keyframes drip {
        45% {
            top: 0;
            border-radius: 200% 10% 200% 200%;
            transform: rotate(-45deg);
        }
        100% {
            top: 0;
            transform: rotate(0deg);
            border-radius: 200%;
        }
    }

    @keyframes dripple {
        0% {
            width: 300px;
            height: 300px;
        }
        25% {
            opacity: 1;
        }
        100% {
            width: 1000px;
            height: 1000px;
            top: -40%;
            opacity: 0;
        }
    }
  </style>
</head>
<body>
  <h1>SUPER<br>CLEAN</h1>
  <div class="drop-container">
    <div class="drop"></div>
  </div>
  <script>
    // Redirigir a la página de login después de que la animación termine
    setTimeout(function() {
      window.location.href = '/login';
    }, 3500); // Ajusta el tiempo de espera a 3 segundos
  </script>
</body>
</html>
