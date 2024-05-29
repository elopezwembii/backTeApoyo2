<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
    <h1>Contacto</h1>
    
    <p>Has recibido un nuevo mensaje de contacto:</p>

    <ul>
        <li><strong>Nombre:</strong> {{ $data['nombre'] }}</li>
        <li><strong>Correo Electrónico:</strong> {{ $data['correo'] }}</li>
        <li><strong>Teléfono:</strong> {{ $data['telefono'] }}</li>
        <li><strong>Empresa:</strong> {{ $data['empresa'] }}</li>
    </ul>

    <p><strong>Mensaje:</strong></p>
    <p>{{ $data['mensaje'] }}</p>
</body>
</html>
