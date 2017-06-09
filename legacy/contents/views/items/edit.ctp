<?php 
echo $this->element('items/edit_scripts', array('plugin' => 'contents')); 

$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;
?>
<section id="items-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				if ($this->data['Item']['status'] == 2) {
					$link = $this->Html->link(
						$this->data['Item']['title'],
						array('plugin' => 'contents', 'controller' => 'items', 'action' => 'view', $this->data['Item']['slug']),
						array('target' => '_blank')
						);
				} else {
					$link = $this->data['Item']['title'];
				}
				printf(__('Modify %s \'%s\'', true), __d('contents', 'Item', true), $link);
			?>
			<?php if ($this->data['Item']): ?>
				<span class="right">
				<?php 
					echo $this->Html->link(__d('contents', 'Preview', true),
						array('action' => 'preview', $this->Form->value('Item.id')),
						array(
							'class' => 'mh-btn-view',
							'target' => '_blank'
						));
				?></span>
			<?php endif; ?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php 
			echo $this->Form->create('Item', array(
				'type' => 'file', 
				'class' => 'autosave',
				'mh-url' => Router::url(array('action' => 'autosave'))
			));
			echo $this->Form->input('App.lastTab', array('type' => 'hidden'));
			echo $this->Form->input('App.returnTo', array('type' => 'hidden'));
			echo $this->Form->input('Item.slug', array('type' => 'hidden'));	
			if ($this->data) {
				echo $this->Form->input('id');
			}
			if ($role == 'owner' || $role == 'editor') {
				echo $this->element('items/forms/editor', array('plugin' => 'contents'));
			} else {
				echo $this->element('items/forms/'.$role, array('plugin' => 'contents'));
			} 
		?>
		<?php echo $this->FForm->end(); ?>
	</div>

</section>

<!-- Modal -->
<div id="upload-form" class="reveal-modal" data-reveal></div>