<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binvenido(a) a Te-Apoyo</title>
    <style>
        /* Estilos generales */
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white; /* Fondo blanco */
            color: #333;
        }
        h1 {
            color: #2c939e;
        }
        p {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer a {
            color: #2c939e;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .footer-logo {
            display: inline-block;
            width: 100px;
            height: 100px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola, {{$email}}!</h1>
        <p>Nos alegra mucho que te hayas registrado en Te-Apoyo, tu plataforma financiera.</p>
        <p>Estos son los datos con los que te registraste</b></p>
        <br>
        <ul>
            <li><strong>Nombres y Apellidos:</strong> {{ $data['nombres'] }} {{ $data['apellidos'] }}</li>
            <li><strong>Correo Electrónico:</strong> {{ $data['email'] }}</li>
            <li><strong>Contraseña:</strong> {{ $data['password'] }}</li>
        </ul>
        <p>Equipo de te apoyo</p>
    </div>
    <div class="footer">
        <p>Este es un correo de notificación automática. Por favor, no respondas a este correo.</p>
        <p>Si tienes alguna pregunta o necesitas asistencia, puedes contactarnos en: <a href="mailto:info@te-apoyo.cl">info@te-apoyo.cl</a></p>
        <p>Visita nuestro sitio web: <a href="https://www.te-apoyo.cl/">Te Apoyo</a></p>
        <div class="footer-content">
            <a href="https://www.te-apoyo.cl/">
                <img src="https://www.te-apoyo.cl/assets/images/logo-1.png" alt="Logo de Te Apoyo" class="footer-logo">
            </a>
        </div>
        <div class="signature">
            Equipo de Te Apoyo<br>
            Tu aliado financiero
        </div>
    </div>
</body>
</html>
