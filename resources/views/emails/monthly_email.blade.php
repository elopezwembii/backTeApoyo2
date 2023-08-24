<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio Mensual</title>
    <style>
        /* Estilos generales */
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
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
        <h1>¡Recordatorio Mensual!</h1>
        <p>Hola {{ $nombre }},</p>
        <p>Te recordamos que estamos a {{$mensaje}} y es un buen momento para completar tus registros en la plataforma.</p>
        <p>Recuerda registrar tus ingresos, gastos, deudas, ahorros y cualquier otro detalle financiero para mantener un control efectivo de tus finanzas.</p>
        <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en ponerte en contacto con nosotros.</p>
        <p>¡Mantener tus registros actualizados te ayudará a tener un mayor control y orden en tus finanzas personales!</p>
        <p>¡Gracias por confiar en nosotros para administrar tus finanzas!</p>
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
