<?php 
	echo $this->Html->script('tinymce/tinymce.min', array('inline' => false)); 
	echo $this->Html->script('/contents/js/editor4', array('inline' => false));
	// echo $this->Html->script('/ui/js/theme_layout', array('inline' => false));
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	
?>


<section id="channels-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Channel', 'contents', $this->Form->value('Channel.title'));
			?>
			<?php if ($this->data['Channel']): ?>
				<span class="right">
				<?php 
					echo $this->Html->link(__d('contents', 'Manage Items', true),
						array('plugin' => 'contents', 'controller' => 'items', 'action' => 'index', 'channel_id' => $this->data['Channel']['id']),
						array('class' => 'mh-btn-index')	
						);
				?></span>
			<?php endif; ?>
		</h1>
	</header>


	<div class="mh-admin-panel-body">

		<dl class="tabs" data-tab>
			<dd class="active"><a href="#tabs-definition"><?php __d('contents', 'Definition'); ?></a></dd>
			<dd><a href="#tabs-options"><?php __d('contents', 'Options'); ?></a></dd>
			<dd><a href="#tabs-labels"><?php __d('contents', 'Labels'); ?></a></dd>
			<dd><a href="#tabs-private"><?php __d('contents', 'Private Channel'); ?></a></dd>
			<dd><a href="#tabs-members"><?php __d('contents', 'Members'); ?></a></dd>
			<dd><a href="#tabs-comments"><?php __d('contents', 'Comments'); ?></a></dd>
		</dl>

		<?php 
			echo $this->Form->create('Channel', array('type' => 'file'));
			echo $this->Form->input('App.lastTab', array('type' => 'hidden')); 
			if ($this->data) {
				echo $this->Form->input('id');
			}
		?>
		
		<div class="tabs-content">
			<div class="content active" id="tabs-definition">
				<?php echo $this->element('channels/forms/definition.tab', array('plugin' => 'contents')); ?>
			</div>
			<div class="content" id="tabs-options">
				<?php echo $this->element('channels/forms/options.tab', array('plugin' => 'contents')); ?>
			</div>
			<div class="content" id="tabs-members">
				<?php echo $this->element('channels/forms/members.tab', array('plugin' => 'contents')); ?>
			</div>
			<div class="content" id="tabs-private">
				<?php echo $this->element('channels/forms/private.tab', array('plugin' => 'contents')); ?>
			</div>
			<div class="content" id="tabs-comments">
				<?php echo $this->element('channels/forms/comments.tab', array('plugin' => 'contents')); ?>
			</div>
			<div class="content" id='tabs-labels'>
				<?php echo $this->element('channels/forms/labels.tab', array('plugin' => 'contents')); ?>
			</div>	
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="comment-form" class="reveal-modal" data-reveal></div>
<!-- Modal -->
<div id="label-form" class="reveal-modal" data-reveal></div>