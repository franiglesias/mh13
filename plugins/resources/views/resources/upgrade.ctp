<?php echo $this->Html->css('/resources/css/resources', null, array('inline' => false)); ?>
<section id="resources-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading">
			<?php
				echo $this->Backend->editHeading($this->data, 'Resource', 'resources', $this->Form->value('Resource.title'));
			?> 
		</h1>
		<p class="mh-admin-panel-menu">
			<?php echo $this->Html->link(
				__d('resources','Manage Resources', true),
				$this->data['App']['returnTo'],
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
				);?> 
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<div class="column col1of4 mh-record" id="resource-metadata">
		
		</div>
		<div class="column col3of4 last-column mh-record mh-record-wide">
		
		<?php echo $this->Form->create('Resource', array('class' => 'media'));?> 
		<?php $path = $this->Form->value('File.path'); ?>
		
			<fieldset class="media-body">
			<legend><?php __d('resources', 'Resource Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php
				echo $this->Form->input('title', array(
					'label' => __d('resources', 'Title', true),
					'class' => 'input-long',
					'readonly' => true
				));
				echo $this->Form->input('Version.comment', array(
					'label' => __d('resources', 'Version Commnent', true),
					'class' => 'input-long'
				));
				echo $this->Upload->file('newfile', array(
					'multiple' => false,
					'mode' => 'attach',
					'update' => '#uploads-list'
				));
			?> 
		</fieldset>
		<?php echo $this->Form->end(array(
			'label' => sprintf(__('Submit %s \'%s\'', true), __d('resources', 'Resource', true), $this->Form->value('Resource.title')), 
			'class' => 'mh-button mh-button-ok', 
			'div' => array('class' => 'submit')
		));?> 
	</div>
</section>