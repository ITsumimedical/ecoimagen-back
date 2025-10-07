<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Fomag</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#fff" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="https://horus-health.com/images/sumi.png" alt="" width="300" height="230" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>Asunto: Constancia de radicación N° - {{ $radicado_id }}</b>
									</td>
								</tr>
								<tr>
									<td style="text-align: justify; padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
										@if($tipo == 'Crear')
										<p>Señor(a) {{ $name }} {{ $apellido }} </p>
										<p>Su PQRF fue radicada con éxito</p>
										<p>La respuesta de su requerimiento sera enviada a su correo electrónico registrado por usted, dando cumplimiento a los tiempos de oportunidad establecidos</p>
										<p>Gracias por su atención, por favor no responder a este email. Los correos electrónicos enviados a esta dirección no serán respondidos.</p>
										<p>Le invitamos a que ingrese en el siguiente enlace <a href="https://horus-health.com/">Autogestion</a> para consultar el estado de su requerimiento</p>
										@elseif($tipo == 'Solucionar')
										@php
										$descripciones = explode("\n",$descripcion)
										@endphp
										<p>Señor(a) {{ $name }} {{ $apellido }} </p>
										<p>le informamos que su solicitud con radicado N• {{ $radicado_id }} ha sido <strong>solucionada</strong>.</p>
										@foreach ($descripciones as $descri)
										<p> {{ $descri }}</p>
										@endforeach
										<p><strong>Queremos conocer tu satisfacción con base en nuestra respuesta a través del siguiente enlace </strong><a href="https://horus-health.com/encuestaSatisfaccionPQR?radicado={{ $radicado_id }}">Calificar</a>.</p>
										<p>Le invitamos a que ingrese en el siguiente enlace <a href="https://horus-health.com/">Autogestion</a> para consultar el estado de sus requerimientos</p>
										
										<p>Gracias por su atención</p>
										@endif
									</td>
								</tr>
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="260" valign="top">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
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
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
										&reg; SUMIMEDICAL 2025<br />
										<a href="https://sumimedical.com/" style="color: #ffffff;">sumimedical.com<font color="#ffffff"></font></a>
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