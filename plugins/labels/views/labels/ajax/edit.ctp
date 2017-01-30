<section class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Page->title('Edit Label'); ?> 
		</h1>
	</header>
		<?php echo $this->Form->create('Label');?> 
		<fieldset>
			<legend><?php __d('labels', 'Label Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<div class="medium-6 columns">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('labels', 'Label title', true),
					));
				?>
				</div>
			</div>
		</fieldset>
		<?php
			echo $this->Form->input('owner_model', array(
				'type' => 'hidden',
				)
			);
			echo $this->Form->input('owner_id', array(
				'type' => 'hidden',
				)
			);
		
		// Prepare the submit button
		// This is the action we need to call to update the permissions list
		$url = array(
			'plugin' => 'labels', 
			'controller' => 'labels', 
			'action' => 'index',
			$this->Form->value('Label.owner_model'),
			$this->Form->value('Label.owner_id')
			);

		echo $this->FForm->ajaxSend($url);
		echo $this->Form->end();
		echo $this->Js->writeBuffer();
		?>
</section>