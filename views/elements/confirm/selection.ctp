<section id="licenses-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php printf(__('About to execute action on a selection of %s', true), __($modelClass, true)); ?> 
		<span class="right">
			<?php echo $this->Html->link(
				__('Cancel', true),
				$referer,
				array('class' => 'mh-btn-cancel')
				);?> 
		</span>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create(null, array('url' => array('action' => 'executeSelection')));?> 
		<fieldset>
			<legend class="mh-message mh-alert"><?php __d('errors', 'Warning! This action is not undoable.'); ?></legend>
			<div class="row">
				<?php
					echo $this->FForm->help(null,
						sprintf(__('You requested <strong>%s</strong> with the following selection of records: ', true), $selectionActions[$action])
					);
				?>
			</div>
			<div class="panel radius clearfix">
				<?php
					$i = 0;
					foreach ($records as $id => $title) {
						echo $this->FForm->input('Title', array(
							'value' => $title, 
							'readonly' => 'readonly', 
						));
						echo $this->FForm->input($modelClass.'.'.$i.'.id', array(
							'type' => 'hidden',
							'value' => $id
						));
						$i++;
					}
					echo $this->Form->input('_Selection.action', array('type' => 'hidden', 'value' => $action));
					echo $this->Form->input('_Selection.referer', array('type' => 'hidden', 'value' => $referer));
				?>
			</div>
			<?php echo $this->FForm->end(array(
				'returnTo' => $referer,
				'discard' => __('Don\'t execute', true),
				'saveAndDone' => __('Yes, continue', true),
				'saveAndWork' => false
			)); ?>
		</fieldset>
		<?php echo $this->Form->end();?> 
	</div>
</section>
