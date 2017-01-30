<p>Esimado/a <strong><?php echo $user['realname'] ?></strong>:</p>
<p>Hemos recibido tu registro y lo vamos a revisar.</p>
<p>Por favor, comprueba tu correo en los próximos días, ya que los administradores te comunicarán su decisión enviándote un email.</p>
<p>Los datos de conexión que has proporcionado son:</p>
<p>Usuario : <strong><?php echo $user['username']; ?></strong></p>
<p>Clave   : <strong><?php echo $user['confirm_password']; ?></strong></p>
<p>No almacenamos contraseñas, si no recuerdas la tuya, tendrás que restaurarla en esta dirección:</p>
<p><?php echo $this->Html->link('Olvidé mi contraseña', Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true)); ?></p>
	
<hr />

<p>Dear <strong><?php echo $user['realname'] ?></strong>:</p>
<p>We have receive your registration and will review it.</p>
<p>Please, check your email in the next days, cause admins will comunicate their decision sending you an email.</p>
<p>The login data you provided is:</p>
<p>Username: <strong><?php echo $user['username']; ?></strong></p>
<p>Password: <strong><?php echo $user['confirm_password']; ?></strong></p>
<p>We don't store passwords in plain view, so if you don't remember yours, you will need to restore it in this url:</p>
<p><?php echo $this->Html->link('I forgot my password',Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true)); ?></p>
	
