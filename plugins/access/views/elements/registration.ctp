<?php
/**
 * Registration
 * 
 * Widget to guide the user to a registration page if registration mode allows it
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

<aside class="mh-widget">
	<header>
		<h1 class="fi-key"><?php __d('access', 'Registration'); ?></h1>
	</header>

	<div class="body">
	<?php if (Configure::read('Access.registration') !== 'no'): ?>
		<?php echo $this->Html->link(
			__d('access', 'Register now', true),
			array(
				'plugin' => 'access',
				'controller' => 'users',
				'action' => 'register'
				),
			array('class' => 'mh-btn-index')
			); ?>
	<?php else: ?>
		<p><?php __d('access', 'Public registration is not available for this site.') ?></p>
	<?php endif; ?>
	</div>

</aside>

