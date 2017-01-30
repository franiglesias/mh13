<?php
	$this->FForm->defaults['labelPosition'] = 'inline';
	$this->FForm->defaults['labelSize'] = 2;
	$this->FForm->defaults['inputSize'] = 10;
?>
<section id="cantineTurns-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'CantineTurn', 'cantine', $this->Form->value('CantineTurn.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineTurn');?> 
			<fieldset>
			<legend><?php __d('cantine', 'CantineTurn Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('cantine', 'Turn', true),
						'div' => 'medium-4 columns',
						'inputSize' => 4
					));
					echo $this->FForm->input('slot', array(
						'label' => __d('cantine', 'Slot', true),
						'div' => 'medium-2 columns end',
						'inputSize' => 2
					));
				?> 
			</div>
		</fieldset>
		<?php if ($this->Form->value('CantineTurn.id')): ?>
		<div class="panel radius clearfix">	
			<div id="cantine-rules-list">
				<?php
					$cantine_rules = $this->requestAction(
						array('plugin' => 'cantine', 'controller' => 'cantine_rules', 'action' => 'index'),
						array('return', 'pass' => array(0 => $this->Form->value('CantineTurn.id')))
					);
					echo $cantine_rules;
				?>
			</div>
			<?php 
				$addUrl = Router::url(array(
					'plugin' => 'cantine', 
					'controller' => 'cantine_rules', 
					'action' => 'add', 
					$this->Form->value('CantineTurn.id')
					), 
					true
				);
				echo $this->FForm->ajaxAdd($addUrl, array(
					'childModel' => 'cantine_rule', 
					'focus' => 'CantineRule.day_of_week.1',
					'class' => 'mh-btn-child-ok'
				)); 
			?>
		</div>		
		<?php endif ?>
		
		<?php echo $this->FForm->end(); ?>
	</div>
</section>	
<!-- Modal -->
<div id="cantine-rule-form" class="reveal-modal" data-reveal></div>
