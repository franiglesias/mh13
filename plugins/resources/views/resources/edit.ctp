<?php 
	echo $this->Html->css('/resources/css/resources', null, array('inline' => false)); 
	echo $this->Html->script('/ui/js/jquery-ui', array('inline' => false)); 
	echo $this->Html->css('/ui/css/jquery-ui', null, array('inline' => false));
	echo $this->Html->script('/ui/js/tabs', array('inline' => false));
?>

<section id="resources-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading">
			<?php
				echo $this->Backend->editHeading($this->data, 'Resource', 'resources', $this->Form->value('Resource.title'));
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
					array('action' => 'delete', $this->Form->value('Resource.id')), 
					array(
						'class' => 'mh-button mh-admin-panel-menu-item mh-button-cancel mh-admin-panel-menu-item-alt',
						'confirm' => sprintf(__('Are you sure you want to delete %s?', true), $this->Form->value('Resource.title'))
 						)
					); ?> 
			<?php endif; ?> 
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<div class="column col1of4 mh-record" id="resource-metadata">
			<?php echo $this->Page->block('/resources/file_metadata', array('file' => $this->data['Current'])); ?>
		</div>
		<div class="column col3of4 last-column mh-record mh-record-wide" id="tabs">
		
			<ul>
				<li><a href="#tabs-1"><?php __d('resources', 'Resource'); ?></a></li>
				<li><a href="#tabs-2"><?php __d('resources', 'History'); ?></a></li>
			</ul>
	
		
		<?php echo $this->Form->create('Resource', array('class' => 'media'));?> 
		<?php $path = $this->Form->value('File.path'); ?>
		
			<fieldset id="tabs-1" class="media-body">
			<legend><?php __d('resources', 'Resource Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php
				echo $this->Form->input('title', array(
					'label' => __d('resources', 'Title', true),
					'class' => 'input-long'
				));
				echo $this->Form->input('description', array(
					'label' => __d('resources', 'Description', true),
					'class' => 'input-long'
				));
				echo $this->Form->input('subject_id', array(
					'label' => __d('resources', 'Subject', true),
					'empty' => true
				));
				echo $this->Form->input('level_id', array(
					'label' => __d('resources', 'Level', true),
					'empty' => true
				));
				echo $this->Form->input('tags', array(
					'label' => __d('resources', 'Tags', true),
					'type' => 'textarea',
					'class' => 'input-long'
				));
			?> 
		<?php echo $this->Form->input('App.returnTo', array('type' => 'hidden')); ?>
		</fieldset>
		<fieldset id="tabs-2">
			<legend><?php __d('resources', 'Versions'); ?></legend>
			<div id="version-history" class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'History'); ?></h2>
				<?php echo $this->Page->block('/resources/version_history', array(
					'versions' => $this->data['Version'], 
					'current' => $this->data['Current']['version'],
					'admin' => true
				)); ?>
			</div>
		</fieldset>
		<?php echo $this->XForm->xEnd(); ?>
	</div>
</section>