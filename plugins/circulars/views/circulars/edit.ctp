<?php 
 	echo $this->Html->script('/circulars/js/selector', array('inline' => false));
	$this->Multilingual->addLanguage('spa', __('Spanish', true), 'glg');
	$this->Multilingual->addLanguage('glg', __('Galician', true), 'spa');
	$this->Circular->bind($this->data);
?>

<section id="circulars-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Backend->editHeading($this->data, 'Circular', 'circulars', $this->Form->value('Circular.title.spa')); ?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#tabs-1"><?php __d('circulars', 'Definition'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('circulars', 'Content'); ?></a></dd>
			<dd><a href="#tabs-5"><?php __d('circulars', 'Other info'); ?></a></dd>
		</dl>
		<?php echo $this->Form->create('Circular');?> 
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<?php if ($this->data) echo $this->Form->input('Circular.id'); ?>
				<?php
				echo $this->FForm->hidden(
					array(
						'circular_type_id',
						'CircularType.template',
						'CircularBox.template'
					)
				);
				?>
				
				<fieldset>
					<legend><?php __d('circulars', 'Circular Definition'); ?></legend>
					<div class="row">
						<?php
						echo $this->FForm->input('CircularType.title', array(
							'label' => __d('circulars', 'Type', true),
							'readonly' => true,
							'div' => 'medium-3 columns'
						));
						echo $this->FForm->select('circular_box_id', array(
							'label' => __d('circulars', 'Box', true),
							'empty' => __d('circulars', 'None', true),
							'options' => $circularBoxes,
							'div' => 'medium-3 columns end'
						));
						?>
					</div>
					<div class="row">
						<?php echo $this->Multilingual->element('circulars/form/common', array('plugin' => 'circulars')); ?>
					</div>
					
				</fieldset>
				<fieldset>
					<legend><?php __d('circulars', 'Addressee'); ?></legend>
					<div class="row">
					<?php 
					echo $this->FForm->translate('Circular.addressee.spa', array(
						'sl' => 'glg', 
						'label' => __d('circulars', 'Addressee (spa)', true),
						'div' => 'medium-5 columns',
						'error' => array(
							'notEmpty' => __d('circulars', 'You must indicate an addressee', true)
						)
					));
					echo $this->FForm->translate('Circular.addressee.glg', array(
						'sl' => 'spa', 
						'label' => __d('circulars', 'Addressee (glg)', true),
						'div' => 'medium-5 columns',
						'error' => array(
							'notEmpty' => __d('circulars', 'You must indicate an addressee', true)
						)
					)); ?>
					<div class="medium-2 columns">
					<?php
					echo $this->Html->link(__d('circulars', 'Course selector', true),
						'#',
						array(
							'mh-target' => '#mh-addressee',
							'mh-readonly-field' => 'CircularAddressee',
							'class' => 'mh-disclose button small round'
						)
					);
					?>
					</div>
					</div>
					<div class="row hide" id="mh-addressee">
					<?php
					echo $this->FForm->select('Addressee.group',array(
						'options' => array(
							1 => __d('circulars', 'Familias', true),
							2 => __d('circulars', 'Profesorado', true),
							4 => __d('circulars', 'Alumnado', true),
						),
						'div' => array('id' => 'AGroup', 'class' => 'medium-3 columns course-selector-field'),
						'label' => __d('circulars', 'Group', true)
					));
					echo $this->FForm->binary('Addressee.stage',array(
						'options' => array(
							1 => __d('circulars', 'E. Infantil', true),
							2 => __d('circulars', 'E. Primaria', true),
							4 => __d('circulars', 'ESO', true),
							8 => __d('circulars', 'Bachillerato', true),
						),
						'div' => array('id' => 'AStages', 'class' => 'medium-3 columns course-selector-field'),
						'label' => __d('circulars', 'Stage', true)
					));
					echo $this->FForm->binary('Addressee.level',array(
						'options' => array(
							1 => __d('circulars', '1º', true),
							2 => __d('circulars', '2º', true),
							4 => __d('circulars', '3º', true),
							8 => __d('circulars', '4º', true),
							16 => __d('circulars', '5º', true),
							32 => __d('circulars', '6º', true)
						),
						'div' => array('id' => 'ALevels', 'class' => 'medium-3 columns course-selector-field'),
						'label' => __d('circulars', 'Level', true)
					));
					echo $this->FForm->binary('Addressee.class',array(
						'options' => array(
							1 => __d('circulars', 'A', true),
							2 => __d('circulars', 'B', true),
							4 => __d('circulars', 'C', true),
						),
						'div' => array('id' => 'AClasses', 'class' => 'medium-3 columns course-selector-field'),
						'label' => __d('circulars', 'Class', true)
					));
					?>
					</div>
				</fieldset>
			</div>
			<?php echo $this->element('circulars/'.$this->Form->value('CircularType.template').'/form', array('plugin' => 'circulars')); ?>
			<div class="content" id="tabs-5">
				<fieldset>
					<legend><?php __d('circulars', 'Publication details'); ?></legend>
					<div class="row">
						<div class="medium-6 columns">
							<?php
							echo $this->FForm->date('pubDate', array(
								'label' => __d('circulars', 'Publication',true),
								'labelSize' => 5,
								'clearable' => true,
								'labelPosition' => 'inline',
								'error' => array(
									'notEmpty' => __d('circulars', 'A publication date should be selected.', true)
								)
							));
							echo $this->FForm->date('expiration', array(
								'label' => __d('circulars', 'Expiration',true),
								'clearable' => true,
								'labelSize' => 5,
								'labelPosition' => 'inline',
								
								'error' => array(
									'notEmpty' => __d('circulars', 'An expiration date should be selected.', true)
								)
							));

							echo $this->FForm->checkbox('web', array(
								'label' => __d('circulars', 'Publish to web', true),
								'labelSize' => 5,
								'labelPosition' => 'inline',
								
							));
							echo $this->FForm->checkbox('publish_event', array(
								'label' => __d('circulars', 'Publish related event', true),
								'labelSize' => 5,
								'labelPosition' => 'inline',
								
							));
							echo $this->Html->link(__d('circulars', 'Preview PDF', true), array(
								'controller' => 'circulars',
								'action' => 'preview',
								$this->Circular->value('id')
							), array(
								'class' => 'mh-btn-view right',
								'target' => 'blank'
							));
							
							?>
						</div>
						<div class="medium-6 columns">
							<?php 
								echo $this->FForm->textarea('copy', array(
									'readonly' => 'true',
									'rows' => 5,
									'label' => __d('circulars', 'Copy this text and paste in the HTML of the circular.', true),
									'value' => $this->Circular->platform('spa'),
								));
								echo $this->FForm->textarea('copy', array(
									'readonly' => 'true',
									'rows' => 5,
									'label' => __d('circulars', 'Copy this text and paste in the HTML of the circular.', true),
									'value' => $this->Circular->platform('glg'),
								));

							?>
						</div>
					</div>
					<div class="row">
					<?php
						echo $this->FForm->input('Creator.realname', array(
							'readonly' => true,
							'label' => __d('circulars', 'Created by', true),
							'div' => 'small-3 columns'
						));
						echo $this->FForm->input('Publisher.realname', array(
							'readonly' => true,
							'label' => __d('circulars', 'Published by', true),
							'div' => 'small-3 columns'
						));
						echo $this->FForm->input('Archiver.realname', array(
							'readonly' => true,
							'label' => __d('circulars', 'Archived by', true),
							'div' => 'small-3 columns'
						));
						echo $this->FForm->input('Revoker.realname', array(
							'readonly' => true,
							'label' => __d('circulars', 'Revoked by', true),
							'div' => 'small-3 columns'
						));
					?></div>
				</fieldset>
			</div>	
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>