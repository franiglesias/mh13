<section id="feed-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Feed', 'aggregator', $this->Form->value('Feed.title'));
			?>
		</h1>
		<?php 
			// if ($this->data) {
			// 	if ($this->data['Feed']['approved'] == false) {
			// 		echo $this->Html->link(
			// 			__d('aggregator', 'Approve this feed', true), 
			// 			array('action' => 'approve', $this->Form->value('Feed.id')), 
			// 			array(
			// 				'class' => 'mh-button mh-admin-panel-menu-item',
			// 				'confirm' => sprintf(__d('aggregator', 'Are you sure you want to approve feed %s?', true), $this->Form->value('Feed.title'))
			// 			)
			// 			
			// 		);
			// 	}
			// }
		?>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Feed', array('type' => 'file'));?>
		<fieldset>
			<legend><?php __d('aggregator', 'Feed data'); ?></legend>
			<?php if ($this->data) {echo $this->Form->input('id');} ?>
			<div class="row">
				<?php
				echo $this->FForm->input('title', array(
					'label' => __d('aggregator', 'Title', true), 
					'div' => 'medium-5 columns'
				));
				echo $this->FForm->textarea('description', array(
					'div' => 'medium-5 columns', 
					'label' => __d('aggregator', 'Description', true)
				));
				echo $this->FForm->checkbox('approved', array(
					'label' => __d('aggregator', 'Approved', true),
					'div' => 'medium-2 columns'
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->select('planet_id', array(
					'label' => __d('aggregator', 'Planet', true),
					'options' => $planets,
					'div' => 'medium-4 columns'
				));
				echo $this->FForm->input('language', array(
					'label' => __d('aggregator', 'Language', true),
					'div' => 'medium-2 columns'
				));
				echo $this->FForm->input('copyright', array(
					'class' => 'input-medium', 
					'label' => __d('aggregator', 'Copyright', true),
					'div' => 'medium-6 columns'
				));
				?>
			</div>
			<div class="row">
				<?php
				echo $this->FForm->input('feed', array(
					'div' => 'medium-6 columns', 
					'readonly' => true,
					'label' => __d('aggregator', 'Feed', true)
				));
				echo $this->FForm->input('url', array(
					'div' => 'medium-6 columns', 
					'label' => __d('aggregator', 'Url', true)
				));
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>