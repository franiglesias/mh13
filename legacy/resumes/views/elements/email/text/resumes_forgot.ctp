Estimada/o <?php echo $resume['Resume']['firstname'] ?>:

Por favor, visita el siguiente enlace para restaurar tu contraseña. Vamos a generar una nueva contraseña por ti y te la enviaremos al correo. Entonces, podrás acceder y cambiarla a tu gusto.

<?php echo Router::url(array('action' => 'recover', $ticket), true); ?> 

De hecho, te recomendamos que cambies esta contraseña provisional por una propia por razones de seguridad.

--------------

Dear <?php echo $resume['Resume']['firstname'] ?>:

Please, visit the following link to restore your password. We will generate a new password for you and send it to your email. Then, you can login and change it as you like.

<?php echo Router::url(array('action' => 'recover', $ticket), true); ?> 

In fact, we recommend that you change this provisory password to one of your own for security reasons.

