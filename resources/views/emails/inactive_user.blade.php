<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Inactividad</title>
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
        <h1>¡Hola, {{$nombre}}!</h1>
        <p>Te extrañamos en nuestra plataforma. Parece que no has iniciado sesión en un tiempo.</p>
        <p>Te animamos a volver a utilizar nuestros servicios y aprovechar al máximo todas sus características.</p>
        <p>¡Esperamos verte pronto de nuevo!</p>
        <p>Equipo de te apoyo</p>
    </div>
    <div class="footer">
        <p>Este es un correo de notificación automática. Por favor, no respondas a este correo.</p>
        <p>Si tienes alguna pregunta o necesitas asistencia, puedes contactarnos en: <a href="mailto:info@te-apoyo.cl">info@te-apoyo.cl</a></p>
        <p>Visita nuestro sitio web: <a href="https://www.te-apoyo.cl/">Te Apoyo</a></p>
        <div class="footer-content">
            <div>
                <p>Contacto: contacto@te-apoyo.cl</p>
                <p>Teléfono: +1234567890</p>
            </div>
            <a href="https://www.te-apoyo.cl/">
                <img src="https://pps.whatsapp.net/v/t61.24694-24/328156052_146312501310235_4239173338662292947_n.jpg?ccb=11-4&oh=01_AdT0PUuSI1eiSEzz3YlmiV617AspYw0dvTG96bDab2El0w&oe=64EA358C&_nc_cat=110" alt="Logo de Te Apoyo" class="footer-logo">
            </a>
        </div>
        <div class="signature">
            Equipo de Te Apoyo<br>
            Tu aliado financiero
        </div>
    </div>
</body>
</html>