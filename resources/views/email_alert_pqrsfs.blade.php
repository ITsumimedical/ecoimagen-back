<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Fomag</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
										<b>PQRSF</b>
									</td>
								</tr>
								<tr>
									@if (isset($pqrsfAlert))
										<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
											<P style="color: #FF0000; font-family: Arial, sans-serif; font-size: 24px;">URGENTE<p>
											<p>Buen día.</p>
											<p>Se le recuerda que tiene una PQRSF con radicado {{ $pqrsfAlert }} y documento {{ $cedula }}.</p>
											<p style="color: #FF0000;">Pronta a vencer y requiere respuesta inmediata.</p>
											<p>Ingresar al modulo de PQRSF <a href="https://horus2.horus-health.com/gestionPqrsf">Horus Health</a>.</p>
										</td>
									@elseif (isset($pqrsfReasignar))
										<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
											<p>Buen día.</p>
											<p>Se le ha reasigando una PQRSF con radicado {{ $pqrsfReasignar }} y documento {{ $cedula }}.</p>
											<p>Recuerde que esta PQRSF tiene un tiempo de cumplimiento.</p>
											<p>Ingresar al modulo de PQRSF para saber el motivo <a href="https://horus2.horus-health.com/gestionPqrsf">Horus Health</a>.</p>
										</td>
									@else
										<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
											<p>Buen día.</p>
											<p>Se le ha asignado una PQRF con radicado {{ $pqrsfid }} y documento {{ $cedula }}.</p>
											<p>Recuerde que esta PQRF tiene un tiempo de cumplimiento.</p>
											<p>Ingresar al modulo de PQRSF <a href="https://horus-health.com/">Horus Health</a>.</p>
										</td>
									@endif
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
										&reg; Sumimedical 2024<br/>
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
