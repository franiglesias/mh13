<div class="content" id="tabs-authoring">
	<fieldset>
		<legend><?php __d('contents', 'Authoring'); ?></legend>
		<div id="mh-item-members" class="panel radius clearfix" style="position:relative;">
		<?php
	 	echo $this->requestAction(
			array(
				'plugin' => 'contents',
				'controller' => 'items',
				'action' => 'members'
				), 
			array('return', 'pass' => array($this->Form->value('Item.id')))
		);?>
		</div>	
		<?php
		$owVars = array(
			'Object' => array(
				'model' => 'Item',
				'id' => $this->Form->value('Item.id')
				),
			'Owner' => array(
				'model' => 'User'
				),
			'OwnerId' => 'ItemNotMember',
			'AccessId' => 'ItemRole',
			'Update' => array(
				'url' => '/contents/items/members/'.$this->Form->value('Item.id'),
				'id' => 'mh-item-members'
				),
			);
			echo $this->Owner->script($owVars);
		?>
	</fieldset>
</div>
