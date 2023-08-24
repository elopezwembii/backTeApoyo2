<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Importante</title>
    <style>
        /* Agrega aquí los estilos CSS que proporcionaste */
        /* ... (copia y pega los estilos) ... */

        /* Estilos personalizados para el correo */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white; /* Fondo blanco */
            color: #333333; /* Cambia al color deseado */
        }
        h1 {
            color: #2c939e; /* Cambia al color deseado */
        }
        p {
            color: #333333; /* Cambia al color deseado */
            margin-bottom: 10px;
        }
        .highlight {
            background-color: #ffd48f; /* Cambia al color deseado */
            padding: 5px 10px;
            border-radius: 3px;
            color: white; /* Cambia al color deseado */
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 14px;
            color: #666666; /* Cambia al color deseado */
        }
        .footer a {
            color: #2c939e; /* Cambia al color deseado */
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .footer-logo {
            display: inline-block;
            width: 100px;
            height:100px;
            margin-right: 5px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Aviso Importante: Control de Gastos</h1>
        <p>Hola {{ $nombre }},</p>
        <p>Te escribimos para informarte que hemos notado que tus gastos totales están llegando a la mitad del presupuesto establecido en tus categorías de gastos.</p>
        <p>Detalles:</p>
        <ul>
            <li>Gastos Totales: ${{ number_format($gastosTotal, 2) }}</li>
            <li>Items de Presupuesto Totales: ${{ number_format($itemsTotalPresupuestos, 2) }}</li>
        </ul>
        <p>Te recomendamos revisar tus gastos y presupuestos para asegurarte de que estás manteniendo el control de tus finanzas.</p>
        <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en ponerte en contacto con nosotros.</p>
        <p class="highlight">Recuerda: ¡Mantener un equilibrio financiero es clave para tu bienestar económico!</p>
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
