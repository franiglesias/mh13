Este es un mensaje enviado automáticamente para indicar que hemos recibido una solicitud de plaza para Bachillerato a nombre de: 

  Estudiante: <?php echo $application['Application']['first_name'].' '.$application['Application']['last_name']; ?> 
         DNI: <?php echo $application['Application']['idcard']; ?> 
    Teléfono: <?php echo $application['Application']['phone']; ?> 
       Email: <?php echo $application['Application']['email']; ?> 

Datos de la solicitud:

       Curso: <?php echo $levels[$application['Application']['level_id']]; ?> en la modalidad de <?php echo $sections[$application['Application']['group']]; ?> 

Se ha enviado un email de confirmación al interesado/a.