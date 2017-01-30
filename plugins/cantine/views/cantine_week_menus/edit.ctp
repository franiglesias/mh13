<?php

?>
<section id="cantine-week-menu-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'CantineWeekMenu', 'cantine', $this->Form->value('CantineWeekMenu.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('CantineWeekMenu');?>
		<fieldset>
			<legend><?php __d('cantine', 'Menu common data'); ?></legend>
		<?php if ($this->data) {echo $this->Form->input('id');} ?>	
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'help' => __d('cantine', 'An identifier for this menu', true),
						'div' => 'medium-4 columns', 
						'label' => __d('cantine', 'Title', true)
					));
				?>
				<div class="medium-8 columns">
					<label><?php __d('cantine', 'Nutrition facts'); ?></label>
					<ul class="small-block-grid-4">
						<li><?php
						echo $this->FForm->input('calories', array(
							'label' => __d('cantine', 'Calories', true),
						));
						?></li>
						<li><?php
						echo $this->FForm->input('proteines', array(
							'label' => __d('cantine', 'Proteines', true),
						));
						?></li>
						<li><?php
						echo $this->FForm->input('lipids', array(
							'label' => __d('cantine', 'Lipids', true),
							));
						?></li>
						<li><?php
						echo $this->FForm->input('glucides', array(
							'label' => __d('cantine', 'Glucides', true),
						));
						?></li>
					</ul>
				</div>
			</div>	
		
		</fieldset>
		<fieldset>
			<legend><?php __d('cantine', 'Menus for every day') ?></legend>
			<div class="row">
				<ul class="medium-block-grid-5">
				<?php $wd = array(
					__('monday', true),
					__('tuesday', true),
					__('wednesday', true),
					__('thursday', true),
					__('friday', true),
				); ?>
				<?php for ($i=0; $i < 5; $i++): ?>
					<li>
						<?php
						echo $this->FForm->textarea('CantineDayMenu.'.$i.'.menu',array(
							'label' => $wd[$i],
							'rows' => 7
						));
						echo $this->Form->text('CantineDayMenu.'.$i.'.weekday', array(
							'value' => $i+1, 
							'type' => 'hidden'
						));
						if (!empty($this->data)) {
							echo $this->Form->input('CantineDayMenu.'.$i.'.id', array(
								'type' => 'hidden'
							));
						}
						?>
					</li>
				<?php endfor; ?>
				</ul>
			</div>
			
		</fieldset>
		<fieldset>
			<legend><?php __d('cantine', 'Starting dates for this menu') ?></legend>
			<div class="row">
				<?php for ($i=0; $i < 4; $i++) {
				
					echo $this->FForm->date('CantineMenuDate.'.$i.'.start', array(
						'div' => 'medium-3 columns',
						'prefixSize' => 3,
						'postfixSize' => 3,
						'clearable' => true
					));
				
					if (!empty($this->data)) {
						echo $this->Form->input('CantineMenuDate.'.$i.'.id', array('type' => 'hidden'));
					}
				} ?>
				
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>