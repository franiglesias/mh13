<section class="mh-admin-panel">
	<header>
		<h1>
			<?php printf(__('About to <strong>%s</strong> %s, identified by <strong>%s</strong>', true), $action, __($modelClass, true),  $record[$modelClass][$displayField]); ?>
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
		<?php echo $this->Form->create(null, array('url' => array('action' => 'delete', $id)));?> 
		<fieldset>
			<legend class="mh-message mh-alert"><?php __d('errors', 'Warning! This action is not undoable.'); ?></legend>
			<?php
				echo $this->FForm->help(null,
					sprintf(__('You requested to delete %s, identified by %s: <strong>%s</strong>.', true),
						__($modelClass, true),
						__($displayField, true),
						 $record[$modelClass][$displayField])
				);
				//echo $this->Form->input('referer', array('type' => 'hidden', 'value' => $referer));
				echo $this->Form->input('identity', array('type' => 'hidden', 'value' =>  $record[$modelClass][$displayField]));
			?>
		</fieldset>
		<?php echo $this->FForm->end(array(
			'returnTo' => $referer,
			'discard' => __('Don\'t execute', true),
			'saveAndDone' => __('Yes, continue', true),
			'saveAndWork' => false
		)); ?>

	</div>
</section>

