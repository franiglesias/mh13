<p>Estimada/o <strong><?php echo $user['User']['realname'] ?></strong>:</p>
<p>Hemos activado tu cuenta, con nombre de usuario: <strong><?php echo $user['User']['username']; ?></strong>.</p>
<p>No almacenamos las contraseñas, así que si no recuerdas la tuya, tendrás que restaurarla en esta dirección:</p>
<p><?php echo $this->Html->link('Olvidé mi contraseña', Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true)); ?></p>

<hr />

<p>Dear <strong><?php echo $user['User']['realname'] ?></strong>:</p>
<p>We have activated your account, with user name: <strong><?php echo $user['User']['username']; ?></strong>.</p>
<p>We don't store passwords in plain view, so if you don't remember yours, you will need to restore it in this url:</p>
<p><?php echo $this->Html->link('I forgot my password',Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true)); ?></p>
