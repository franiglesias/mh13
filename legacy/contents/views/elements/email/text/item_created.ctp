<?php echo $user['User']['realname'] ?> ha creado un nuevo artículo titulado "<?php echo $item['Item']['title']; ?>" en el canal "<?php echo $channel['Channel']['title']; ?>" y lo ha marcado como listo para revisar.

Para proceder a revisarlo y publicarlo, por favor, visita la siguiente dirección:

<?php echo Router::url(array(
	'plugin' => 'contents',
	'controller' => 'items',
	'action' => 'edit',
	$item['Item']['id']
	)
	, true); ?> 

--------------

User <?php echo $user['User']['realname'] ?> has created a new Item with Title "<?php echo $item['Item']['title']; ?>" in your Channel "<?php echo $channel['Channel']['title']; ?>" and marked it as Ready for Review.

To proceed to review and publish it, please, visit the following URL:

<?php echo Router::url(array(
	'plugin' => 'contents',
	'controller' => 'items',
	'action' => 'edit',
	$item['Item']['id']
	)
	, true); ?> 


