<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asignación de Evento Adverso</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <table width="600" align="center" style="background: #ffffff; border: 1px solid #ccc; padding: 20px;">
        <tr>
            <td align="center">
                <img src="{{ url('/images/logo.png') }}" alt="Logo" width="120">
            </td>
        </tr>
        <tr>
            <td>
                <h2 style="color:#333;">Asignación de Evento Adverso</h2>
                <p>Buen día,</p>
                <p>Se le ha asignado un evento adverso para su gestión:</p>

                <p><strong>Radicado del suceso:</strong> {{ $evento->id }}</p>
                <p><strong>Motivo asignación:</strong> {{ $motivo }}</p>

                <p>Por favor, ingrese al sistema para revisarlo.</p>

                <p style="margin-top:20px;">Saludos,<br>Equipo Horus-Health</p>
            </td>
        </tr>
        <tr>
            <td align="center" bgcolor="#312783" style="color: #fff; padding: 10px;">
                &copy; Horus-Health 2025
            </td>
        </tr>
    </table>
</body>
</html>
