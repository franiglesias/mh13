<div id="meritTypes-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php __d('resumes', 'Search resumes'); ?>
		</h1>
		<p class="mh-admin-panel-menu">
			<?php echo $this->Html->link(
				__d('resumes', 'Index', true),
				array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'index'),
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-admin')
				); ?>
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Resume');?>
		<fieldset>
			<legend><?php __d('resumes', 'Search Resumes'); ?></legend>
			<?php
				echo $this->Form->input('terms', array(
					'label' => __d('resumes', 'Search terms', true),
					'after' => __d('resumes', '<p>You can use boolean operator such +term (means AND), -term (means NO). No operator implies OR.</p>', true),
					'class' => 'input-long'
				));
			?>
			</fieldset>
		<?php echo $this->Form->end(array(
			'label' => __d('resumes', 'Search', true), 
			'class' => 'mh-button'
		));?>
	</div>
</div>
