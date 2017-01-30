Estimada/o <?php echo $user['User']['realname'] ?>:

Hemos activado tu cuenta, con nombre de usuario: <?php echo $user['User']['username']; ?>.

No almacenamos las contraseñas, así que si no recuerdas la tuya, tendrás que restaurarla en esta dirección:

<?php echo Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true); ?> 

--------------

Dear <?php echo $user['User']['realname'] ?>:

We have activated your account, with user name: <?php echo $user['User']['username']; ?>.

We don't store passwords in plain view, so if you don't remember yours, you will need to restore it in this url:

<?php echo Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true); ?> 
	
