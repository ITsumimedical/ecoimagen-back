<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Mesa de Ayuda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#fff"
                            style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="{{ url('/images/logoEcoimagen.png') }}" alt="Logo" width="300" height="230"
                                style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>Mesa de Ayuda</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Buen día,</p>
                                        <p>Le informamos que un caso en la mesa de ayuda ha sido {{ $accion }}</p>

                                        @if($accion === 'comentado')
                                            <p><strong>Comentario: </strong>{{ $motivo }}</p>
                                        @endif

                                        @if($accion === 'Asignado fecha tentativa de solución de su caso' && !empty($motivo))
                                            <p>{!! nl2br(e($motivo)) !!}</p>
                                        @endif

                                        <p><strong>Radicado:</strong> {{ $mesaAyuda->id }}</p>
                                        <p><strong>Asunto:</strong> {{ $mesaAyuda->asunto }}</p>
                                        <p><strong>Descripción:</strong> {{ $mesaAyuda->descripcion }}</p>
                                        <p>Por favor, ingrese al módulo de Mesa de Ayuda para más detalles.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <p>
                                                                    <a href="https://sumi.horus-health.com/mesaAyuda/misAsignadas"
                                                                        style="color: #ffffff;">Mesa Ayuda<font
                                                                            color="#ffffff"></font></a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#28b463" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                        &reg; Sumimedical 2024<br />
                                        <a href="https://sumi.horus-health.com/" style="color: #ffffff;">Mesa Ayuda
                                            <font color="#ffffff"></font></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
