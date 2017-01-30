<?php
	/**
	 * Addon to public main navigation 
	 *
	 * @author Fran Iglesias
	 */
?>
<ul class="right access-icons">
	<?php if (!($user = $this->Session->read('Auth.User'))): ?>
		<li><?php echo $this->Html->link('<i class="fi-key"></i>',
			array(
				'prefix' => false,
				'plugin' => 'access',
				'controller' => 'users',
				'action' => 'login'
				),
			array('escape' => false)
			); ?></li>
	<?php else: ?>
		<li><?php echo $this->Html->link('<i class="fi-clipboard-notes"></i>',
			array(
				'prefix' => false,
				'plugin' => 'access',
				'controller' => 'users',
				'action' => 'dashboard'
				),
			array('escape' => false)
			); ?></li> 
		<li><?php echo $this->Html->link('<i class="fi-power"></i>',
			array(
				'prefix' => false,
				'plugin' => 'access',
				'controller' => 'users',
				'action' => 'logout'
				),
			array('escape' => false, 'id' => 'revokeButton')
			); ?></li>
	<?php endif; ?>
</ul>
