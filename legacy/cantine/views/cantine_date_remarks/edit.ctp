<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>
<section id="cantine-date-remarks-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'CantineDateRemark', 'cantine', $this->Form->value('CantineDateRemark.date'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineDateRemark');?>
		<fieldset>
			<legend><?php __d('cantine', 'Remarks for date'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>
		<div class="row">
			<?php
				echo $this->FForm->date('date', array(
					'label' => __d('cantine', 'Date', true),
					'clearable' => true,
					'div' => 'medium-3 columns',
					'inputSize' => 2
				));
				echo $this->FForm->textarea('remark', array(
					'label' => __d('cantine', 'Change or remark', true),
					'div' => 'medium-9 columns'
				));
			?>
		</div>	
		
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>

