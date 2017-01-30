Esimado/a <?php echo $user['realname'] ?>:

Hemos recibido tu registro y lo vamos a revisar.

Por favor, comprueba tu correo en los próximos días, ya que los administradores te comunicarán su decisión enviándote un email.

Los datos de conexión que has proporcionado son:

Usuario : <?php echo $user['username']; ?>
Clave   : <?php echo $user['confirm_password']; ?>

No almacenamos contraseñas, si no recuerdas la tuya, tendrás que restaurarla en esta dirección:

<?php echo Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true); ?> 
	
--------------

Dear <?php echo $user['realname'] ?>:

We have receive your registration and will review it.

Please, check your email in the next days, cause admins will comunicate their decision sending you an email.

The login data you provided is:

Username: <?php echo $user['username']; ?>
Password: <?php echo $user['confirm_password']; ?>

We don't store passwords in plain view, so if you don't remember yours, you will need to restore it in this url:

<?php echo Router::url(array(
	'plugin' => 'access',
	'controller' => 'users',
	'action' => 'forgot'
	)
	, true); ?> 
	
