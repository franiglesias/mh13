<p><?php echo $user['User']['realname'] ?> ha creado un nuevo artículo titulado "<?php echo $item['Item']['title']; ?>" en el canal "<?php echo $channel['Channel']['title']; ?>" y lo ha marcado como listo para revisar.</p>
<p>Para proceder a revisarlo y publicarlo, por favor, visita la siguiente dirección:</p>
<p><?php echo $this->Html->link('Revisar y editar el artículo.',Router::url(array(
	'plugin' => 'contents',
	'controller' => 'items',
	'action' => 'edit',
	$item['Item']['id']
	)
	, true)); ?> </p>

<hr />

<p>User <?php echo $user['User']['realname'] ?> has created a new Item with Title "<?php echo $item['Item']['title']; ?>" in your Channel "<?php echo $channel['Channel']['title']; ?>" and marked it as Ready for Review.</p>
<p>To proceed to review and publish it, please, visit the following URL:</p>
<p><?php echo $this->Html->link('Review and edit the article.', Router::url(array(
	'plugin' => 'contents',
	'controller' => 'items',
	'action' => 'edit',
	$item['Item']['id']
	)
	, true)); ?> </p>


