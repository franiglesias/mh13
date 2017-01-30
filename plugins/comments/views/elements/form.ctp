<?php

	$defaults = array(
		'user' => array('id' => false, 'realname' => false),
		'mode' => COMMENTS_FREE,
		'redirect' => null,
		'model' => $this->Form->value('object_model'),
		'fk' => $this->Form->value('object_fk'),
		'message' => false
	);
	
	extract($defaults, EXTR_SKIP);

?>

<div id="sending" style="display: none;"><?php echo $this->XHtml->ajaxLoading(); ?></div>
<div class="mh-admin-panel-body">
	<a name="mh-comment-form"></a>
	<?php if ($message): ?>
		 <p class="mh-inline-message"><?php echo $message; ?></p>
	<?php endif; ?>
	<?php echo $this->Form->create('Comment', array('url' => array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'comment')));?> 
		<fieldset>
		<legend><?php __d('comments', 'Add your Comment'); ?></legend>
		<?php if ($this->data) echo $this->Form->input('id'); ?>	
		<?php
			echo $this->Form->input('comment', array(
					'label' => __d('comments', 'Comment', true),
					'type' => 'textarea', 
					'class' => 'input-long', 
					'rows' => 5
					)
				);
			echo $this->Form->input('name', array(
					'label' => __d('comments', 'Name', true), 
					'value' => $user['realname']
					)
				);
			echo $this->Comment->turing($test);
			echo $this->Form->input('object_model', array('type' => 'hidden', 'value' => $model));
			echo $this->Form->input('object_fk', array('type' => 'hidden', 'value' => $fk));
			echo $this->Form->input('redirect', array('type' => 'hidden', 'value' => $redirect));
			echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['id']));
			echo $this->Form->input('timestamp', array('type' => 'hidden', 'value' => time()));
		?> 
	</fieldset>
	<?php echo $this->Js->submit(__d('comments', 'Send comment', true), array(
		'id' => 'mh-comment-send',
		'class' => 'mh-button mh-button-ok', 
		'div' => array('class' => 'submit fixed-submit'),
		'url' => array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'comment'),
		'evalScripts' => true,
		'buffer'=> false,
		'before' => $this->Js->get('#sending')->effect('fadeIn'),
		'complete' => $this->Js->request(array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'display', $model, $fk), array('update' => '#comments-display')),
		'update' => '#comments-form',
	));?> 
	<?php echo $this->Form->end() ?>
</div>
