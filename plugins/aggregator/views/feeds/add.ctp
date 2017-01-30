<section id="feed-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php 
				echo $this->Backend->editHeading($this->data, 'Feed', 'aggregator', $this->Form->value('Feed.title'));
			?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Feed', array('type' => 'file'));?>
		<fieldset>
			<legend><?php __d('aggregator', 'Feed data'); ?></legend>
			<div class="row">
				<?php
					echo $this->Form->input('feed', array(
						'class' => 'input-long',
						'label' => __d('aggregator', 'Feed', true),
						'after' => __d('aggregator', '<p>The URI of the feed.</p>', true)
						)
					);
					echo $this->Form->input('planet_id', array(
						'after' => __d('aggregator', '<p>Select the planet to aggregate this feed.</p>', true),
						'label' => __d('aggregator', 'Planet', true)
						)
					);
				?>
			</div>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>