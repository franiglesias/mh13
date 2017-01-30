<?php echo $this->Html->css('/resources/css/resources', null, array('inline' => false)); ?>
<section id="resources-view" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading">
			<?php printf(__d('resources', 'Viewing resource \'%s\'', true), $this->Form->value('Resource.title')); ?> 
		</h1>
		<p class="mh-admin-panel-menu">
			<?php echo $this->Html->link(
				__d('resources', 'Return to search results', true),
				$this->data['App']['returnTo'],
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
				);
				echo $this->Html->link(
					__d('resources', 'Print', true),
					'javascript:window.print()',
					array('class' => 'mh-button mh-admin-panel-menu-item mh-admin-panel-menu-item-alt mh-button-print')
				);	
			?> 
		</p>
	</header>
	<div class="mh-admin-panel-body">
		
		<div class="column col1of4 mh-record" id="resource-metadata">
			<?php echo $this->Page->block('/resources/file_metadata', array('file' => $this->data['Current'])); ?>
		</div>
		<div class="column col3of4 last mh-record mh-record-wide">
			<div class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'Title'); ?></h2>
				<p><?php echo $this->data['Resource']['title']; ?></p>
			</div>
			<div class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'Description'); ?></h2>
				<p><?php echo $this->data['Resource']['description']; ?></p>
			</div>
			<?php if ($this->data['Resource']['subject_id']): ?>
			<div class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'Subject'); ?></h2>
				<p><?php echo $subjects[$this->data['Resource']['subject_id']]; ?></p>
			</div>
			<?php endif ?>
			<?php if ($this->data['Resource']['level_id']): ?>
			<div class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'Level'); ?></h2>
				<p><?php echo $levels[$this->data['Resource']['level_id']]; ?></p>
			</div>
			<?php endif ?>
			
			<div class="mh-record-field">
				<h2 class="mh-record-field-label"><?php __d('resources', 'History'); ?></h2>
				<?php echo $this->Page->block('/resources/version_history', array(
					'versions' => $this->data['Version'],
					'current' => $this->data['Current']['version']
				)); ?>
			</div>

			<div class="mh-record-field only-print">
				<h2 class="mh-record-field-label"><?php __d('resources', 'Tags'); ?></h2>
				<p><?php echo $this->data['Resource']['tags']; ?></p>
			</div>
			
		<?php echo $this->Form->create('Resource', array('class' => 'media no-print'));?> 
			<fieldset>
			<legend><?php __d('resources', 'Contribute to tagging'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<?php
				echo $this->Form->input('tags', array(
					'label' => __d('resources', 'Tags', true),
					'type' => 'textarea',
					'class' => 'input-long'
				));
			?> 
		<?php echo $this->Form->input('App.returnTo', array('type' => 'hidden')); ?></fieldset>
		<?php echo $this->Form->end(array(
			'label' => sprintf(__('Submit %s \'%s\'', true), __d('resources', 'Resource', true), $this->data['Resource']['title']), 
			'class' => 'mh-button mh-button-ok', 
			'div' => array('class' => 'submit')
		));?> 
			
		</div>
	</div>
</section>