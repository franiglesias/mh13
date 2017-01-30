<?php
/**
 * Widget to guide the user to password recovery
 * 
 * Description
 *
 * @package elements.access.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/





?>
<div class="body">
<?php echo $this->Html->link(
	__d('access', 'Try our recovery form', true),
	array(
		'plugin' => 'access',
		'controller' => 'users',
		'action' => 'forgot'
		),
	array('class' => 'mh-btn-index')
	); ?>
</div>
