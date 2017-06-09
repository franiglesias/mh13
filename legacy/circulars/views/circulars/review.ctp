<?php 
	$this->Multilingual->addLanguage('spa', __('Spanish', true), 'glg');
	$this->Multilingual->addLanguage('glg', __('Galician', true), 'spa');
	// $this->Circular->bind($this->data);
?>

<section id="circulars-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php echo $this->Page->title(sprintf(__d('circulars', 'Review circular %s', true), $this->Circular->mixValue('title'))); ?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php $this->Form->create('Circular');?> 

		<fieldset>
			<legend><?php __d('circulars', 'Publication details'); ?></legend>
			<div class="row">
				<?php $this->Circular->setLanguage('spa'); ?>
				<div class="medium-6 columns">
					<?php echo $this->Circular->format('content', 'html'); ?>
					
				</div>
				<?php $this->Circular->setLanguage('glg'); ?>
				<div class="medium-6 columns">
					<?php echo $this->Circular->format('content', 'html'); ?>
				</div>
				
			</div>
			<div class="row">
				<?php
				echo $this->FForm->text('pubDate', array(
					'label' => __d('circulars', 'Publication',true),
					'div' => 'medium-3 columns',
					'readonly' => true,
					'value' => $this->Circular->format('pubDate', 'date'),
					'clearable' => false,
				));
				echo $this->FForm->text('expiration', array(
					'label' => __d('circulars', 'Expiration',true),
					'div' => 'medium-3 columns',
					'readonly' => true,
					'value' => $this->Circular->format('expiration', array('date' => true, 'empty' => __d('circulars', 'End of school year', true))),
					'clearable' => false,
				));
				
				// echo $this->FForm->checkbox('web', array(
				// 	'label' => __d('circulars', 'Publish to web', true),
				// 	'div' => 'medium-2 columns end'
				// ));
				echo $this->Html->link(__d('circulars', 'Preview PDF', true), array(
					'controller' => 'circulars',
					'action' => 'preview',
					$this->Circular->value('id')
				), array(
					'class' => 'mh-btn-view',
					'target' => 'blank'
				));
				?>
			</div>
			
			<div class="row">
			<?php 
				echo $this->FForm->textarea('copy', array(
					'readonly' => 'true',
					'rows' => 15,
					'label' => __d('circulars', 'Copy this text and paste in the HTML of the circular.', true),
					'value' => $this->Circular->platform('spa'),
					'div' => 'medium-6 columns'
				));
				echo $this->FForm->textarea('copy', array(
					'readonly' => 'true',
					'rows' => 15,
					'label' => __d('circulars', 'Copy this text and paste in the HTML of the circular.', true),
					'value' => $this->Circular->platform('glg'),
					'div' => 'medium-6 columns'
				));
				
			?>
			</div>
			<div class="row">
			<?php
				// echo $this->FForm->input('Creator.realname', array(
				// 	'readonly' => true,
				// 	'label' => __d('circulars', 'Created by', true),
				// 	'div' => 'small-3 columns'
				// ));
				// echo $this->FForm->input('Publisher.realname', array(
				// 	'readonly' => true,
				// 	'label' => __d('circulars', 'Published by', true),
				// 	'div' => 'small-3 columns'
				// ));
				// echo $this->FForm->input('Archiver.realname', array(
				// 	'readonly' => true,
				// 	'label' => __d('circulars', 'Archived by', true),
				// 	'div' => 'small-3 columns'
				// ));
				// echo $this->FForm->input('Revoker.realname', array(
				// 	'readonly' => true,
				// 	'label' => __d('circulars', 'Revoked by', true),
				// 	'div' => 'small-3 columns'
				// ));
			?></div>
		</fieldset>
		<p><?php echo $this->Html->link(__d('circulars', 'Back to circulars', true), array('action' => 'index'), array('class' => 'mh-btn-back')); ?></p>
	</div>
</section>