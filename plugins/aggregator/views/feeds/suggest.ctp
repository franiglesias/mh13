<div class="mh-page">
	<header>
		<h1><?php __d('aggregator', 'Suggest a feed'); ?></h1>
		<h2><?php __d('aggregator', 'A source of news to enrich our content'); ?></h2>
	</header>
	<div class="body">
		<!-- Content here -->
		<div class="row">
		<?php echo $this->Form->create('Feed', array('class' => 'frontend'));?>
		<fieldset>
	 		<legend><?php __d('aggregator', 'Feed'); ?></legend>
			<div class="row">
			<?php
				if (!isset($planet_id)) $planet_id = null;
				echo $this->FForm->input('feed', array(
						'label' => __d('aggregator', 'Feed', true),
						'help' => __d('aggregator', 'The URI of the feed.', true),
						)
					);
			?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->select('planet_id', array(
						'label' => __d('aggregator', 'Planet', true),
						'empty' => __d('aggregator', '--Sorry, I\'m not sure--', true),
						'value' => $planet_id,
						'options' => $planets,
						'help' => __d('aggregator', 'Select the planet to aggregate this feed.', true),
						'div' => 'medium-6 columns end'
						)
					);
				?>
			</div>

		</fieldset>
		<?php echo $this->FForm->end(array(
			'discard' => false,
			'saveAndWork' => false
		)); ?>
		</div>
	</div>
</div>