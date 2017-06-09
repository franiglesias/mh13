<section id="comments-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Comment', 'comments', $this->Form->value('Comment.comment'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Comment');?> 
			<fieldset>
			<legend><?php __d('comments', 'Comment'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<div class="row">
				<?php
				echo $this->FForm->textarea('comment', array(
					'label' => __d('comments', 'Comment', true),
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->text('name', array(
					'label' => __d('comments', 'Commenter', true),
					'div' => 'medium-4 columns'
				));
				echo $this->FForm->email('email', array(
					'label' => __d('comments', 'Email', true),
					'div' => 'medium-4 columns'
				));
				echo $this->FForm->select('approved', array(
					'options' => $states, 
					'label' => __d('comments', 'Approved', true),
					'div' => 'medium-3 columns end'
				));
				?>
			</div>
			<?php
				echo $this->Form->input('object_model', array('type' => 'hidden'));
				echo $this->Form->input('object_fk', array('type' => 'hidden'));
				echo $this->Form->input('App.returnTo', array('type' => 'hidden')); 
			?>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>