<nav class="top-bar" data-topbar>
	<section class="top-bar-section">
	<?php echo $this->Page->block('/menus/bar', array(
		'bar' => 'backend', 
		'title' => false, 
		'id' => 'mh-backend-menu',
		'search' => false,
		'cache' => array(
			'time' => '1 week',
			'key' => 'backend'.$this->Session->read('Auth.User.id')
			)
		)); ?>
		<ul class="right access-icons">
			<?php if (!($user = $this->Session->read('Auth.User'))): ?>
			<li><?php echo $this->Html->link('<i class="fi-key"></i>',
				array(
					'prefix' => false,
					'plugin' => 'access',
					'controller' => 'users',
					'action' => 'login'
					)
				); ?></li>
			<?php else: ?>
			<li><?php echo $this->Html->link('<i class="fi-torso"></i>',
				array(
					'prefix' => false,
					'plugin' => 'access',
					'controller' => 'users',
					'action' => 'profile'
					),
				array('escape' => false)
				); ?></li> 
		
			<li><?php echo $this->Html->link('<i class="fi-clipboard-notes"></i>',
				array(
					'prefix' => false,
					'plugin' => 'access',
					'controller' => 'users',
					'action' => 'dashboard'
					),
				array('escape' => false)
				); ?></li> 
			<li><?php echo $this->Html->link('<i class="fi-home"></i>', 
				'/',
				array('escape' => false)		
			); ?></li>
			<li><?php echo $this->Html->link('<i class="fi-power"></i>',
				array(
					'prefix' => false,
					'plugin' => 'access',
					'controller' => 'users',
					'action' => 'logout'
					),
				array('escape' => false)
				); ?></li>
			<?php endif; ?>
		</ul>
	</section>
</nav>