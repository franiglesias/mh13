<section id="batches-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading">
			<?php
				echo $this->Backend->editHeading($this->data, 'Batch', 'resources', $this->Form->value('Batch.id'));
			?> 
		</h1>
		<p class="mh-admin-panel-menu">
			<?php echo $this->Html->link(
				__('Admin', true),
				$this->data['App']['returnTo'],
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
				);?> 
			<?php if ($this->data): ?> 
				<?php echo $this->Html->link(
					__('Delete', true), 
					array('action' => 'delete', $this->Form->value('Batch.id')), 
					array(
						'class' => 'mh-button mh-admin-panel-menu-item mh-button-cancel mh-admin-panel-menu-item-alt',
						'confirm' => sprintf(__('Are you sure you want to delete %s?', true), $this->Form->value('Batch.id'))
 						)
					); ?> 
			<?php endif; ?> 
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Batch');?> 
			<fieldset>
			<legend><?php __d('resources', 'Batch Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php
				echo $this->Form->input('subject_id', array(
					'empty' => true
				));
				echo $this->Form->input('level_id', array(
					'empty' => true
				));
				echo $this->Form->input('title', array(
					'label' => __d('resources', 'Title', true),
					'class' => 'input-long'
				)); 
				echo $this->Form->input('description', array(
					'label' => __d('resources', 'Description', true),
					'class' => 'input-long'
				));
				echo $this->Form->input('tags', array(
					'label' => __d('resources', 'Tags', true),
					'class' => 'input-long',
					'type' => 'textarea'
				));
				echo $this->Upload->file('files', array(
					'label' => __d('resources', 'Files', true),
					'mode' => 'attach',
					'multiple' => true,
					'update' => '#uploads-list',
					'url' => array(
						'plugin' => 'uploads',
						'controller' => 'uploads',
						'action' => 'index',
						'Batch',
						$this->Form->value('id')
						)
					)
				);
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				
			?> 
		<?php echo $this->Form->input('App.returnTo', array('type' => 'hidden')); ?>		</fieldset>
		<?php echo $this->Form->end(array(
			'label' => sprintf(__('Submit %s', true), __d('resources', 'Batch', true)), 
			'class' => 'mh-button mh-button-ok', 
			'div' => array('class' => 'submit fixed-submit')
		));?> 
	</div>
</section>