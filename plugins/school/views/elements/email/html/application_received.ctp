<p>Este es un mensaje enviado automáticamente para indicar que hemos recibido una solicitud de plaza para Bachillerato.</p>
<table>
	<tr>
		<td><strong>Estudiante</strong></td>
		<td><?php  echo $application['Application']['first_name'].' '.$application['Application']['last_name']; ?></td>
	</tr>
	<tr>
		<td><strong>DNI</strong></td>
		<td><?php echo $application['Application']['idcard']; ?></td>
	</tr>
	<tr>
		<td><strong>Teléfono</strong></td>
		<td><?php echo $application['Application']['phone']; ?></td>
	</tr>
	<tr>
		<td><strong>Email</strong></td>
		<td><?php echo $application['Application']['email']; ?></td>
	</tr>
</table>
<p><strong>Datos de la solicitud</strong></p>

<p>Curso <strong><?php echo $levels[$application['Application']['level_id']]; ?></strong> en la modalidad de <strong><?php echo $sections[$application['Application']['group']]; ?></strong></p>

<p>Se ha enviado un email de confirmación al interesado/a.</p>