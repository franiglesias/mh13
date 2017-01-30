<fieldset>
	<legend><?php __d('contents', 'Manage Channel Labels'); ?></legend>
	<div class="panel radius clearfix">
		<div id="labels-list">
			<?php
				echo $this->requestAction(
					array('plugin' => 'labels', 'controller' => 'labels', 'action' => 'index'),
					array('return', 'pass' => array('Channel', $this->Form->value('Channel.id')))
				);
			?>
		</div>
		<?php 
			$addUrl = Router::url(array(
				'plugin' => 'labels', 
				'controller' => 'labels', 
				'action' => 'add', 
				'Channel',
				$this->Form->value('Channel.id')
				), 
				true
			);
			echo $this->FForm->ajaxAdd($addUrl, array(
				'childModel' => 'Label', 
				'class' => 'mh-btn-child-ok'
			)); 
			
		?>
		
	</div>
</fieldset>