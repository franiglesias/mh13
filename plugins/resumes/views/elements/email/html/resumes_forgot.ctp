<p>Estimada/o <strong><?php echo $resume['Resume']['firstname'] ?></strong>:</p>
<p>Por favor, visita el siguiente enlace para restaurar tu contraseña. Vamos a generar una nueva contraseña por ti y te la enviaremos al correo. Entonces, podrás acceder y cambiarla a tu gusto.</p>
<p><?php echo $this->Html->link('Generar una nueva contraseña.', Router::url(array('action' => 'recover', $ticket), true)); ?> </p>
<p>De hecho, te recomendamos que cambies esta contraseña provisional por una propia por razones de seguridad.</p>

<hr />

<p>Dear <strong><?php echo $resume['Resume']['firstname'] ?></strong>:</p>
<p>Please, visit the following link to restore your password. We will generate a new password for you and send it to your email. Then, you can login and change it as you like.</p>
<p><?php echo $this->Html->link('Create a new password.',Router::url(array('action' => 'recover', $ticket), true)); ?> </p>
<p>In fact, we recommend that you change this provisory password to one of your own for security reasons.</p>

