<fieldset>
	<legend><?php __d('contents', 'Team') ?></legend>
	<div id="mh-channel-members" class="panel radius clearfix" style="position: relative;">
	<?php
 	echo $this->requestAction(
		array(
			'plugin' => 'contents',
			'controller' => 'channels',
			'action' => 'members'
			), 
		array('return', 'pass' => array($this->Form->value('Channel.id')))
	);?>
	</div>	
	<?php
		$owVars = array(
			'Object' => array(
				'model' => 'Channel',
				'id' => $this->Form->value('Channel.id')
				),
			'Owner' => array(
				'model' => 'User'
				),
			'OwnerId' => 'ChannelNotMember',
			'AccessId' => 'ChannelRole',
			'Update' => array(
				'url' => '/contents/channels/members/'.$this->Form->value('Channel.id'),
				'id' => 'mh-channel-members'
				),
			);
			echo $this->Owner->script($owVars);
	?>
</fieldset>
