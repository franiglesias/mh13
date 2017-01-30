<fieldset>
	<legend><?php __d('contents', 'Manage Comments'); ?></legend>
	<?php if ($this->Form->value('Channel.id')): ?>
	<div class="panel radius clearfix">
		<div id="comments-list">
			<?php
				echo $this->requestAction(
					array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index'),
					array('return', 'pass' => array('Contents.Channel', $this->Form->value('Channel.id')))
				);
			?>
		</div>
		<?php 
			$addUrl = Router::url(array(
				'plugin' => 'access', 
				'controller' => 'permissions', 
				'action' => 'add', 
				$this->Form->value('Role.id')
				), 
				true
			);
		?>
	</div>
	<?php endif ?>
</fieldset>
