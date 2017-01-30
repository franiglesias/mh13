<?php $this->License->bind($this->data); ?>
<section id="licenses-edit" class="mh-admin-panel">
	<header>
		<h1><?php echo $this->License->format('license', 'string', __('Editing %s', true)); ?></h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php
			echo $this->Form->create('License');
			$this->FForm->defaults['labelPosition'] = 'inline';
			$this->FForm->defaults['labelSize'] = 2;
		?>
		<fieldset>
			<legend><?php echo $this->Html->tag('legend', __d('licenses', 'License Definition', true)) ?></legend>
			<?php
				if (!empty($this->data['License'])) {
					echo $this->Form->input('License.id');
				}
			?>
			<div class="row">
				<?php
					echo $this->FForm->input('license', array(
						'label' => __d('licenses', 'License', true),
						'help' => __d('licenses', 'Descriptive name for the license.', true)
					));
					echo $this->FForm->input('type', array(
						'label' => __d('licenses', 'Type', true),
						'help' => __d('licenses', 'Type or family of licenses.',true)
					));
					echo $this->FForm->textarea('code', array(
						'label' => __d('licenses', 'Code', true),
						'help' => __d('licenses', 'Paste here the code provided to show the license. Leave blank if you don\'t have one.',true)
					));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end() ?>
	</div>
</section>