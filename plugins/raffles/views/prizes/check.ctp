<article class="mh-page">
	<header>
		<h1><?php __d('raffles', 'Check your tickets'); ?></h1>
	</header>
	<div class="row medium-collapse">
		<div class="medium-7 column">
			<?php echo $this->Html->link(
				__d('raffles', 'Prizes list', true),
				array(
					'plugin' => 'raffles',
					'controller' => 'prizes',
					'action' => 'prizelist'
				),
				array('class' => 'button mh-btn-forward')
			); ?>
		
			<?php if (isset($result)): ?>
				<?php if ($result): ?>
					<h2><?php __d('raffles', 'Congratulations! Your ticket has a prize.'); ?></h2>
					<p><strong><?php __d('raffles', 'Your ticket: '); ?></strong> <?php echo $result['Prize']['number']; ?></p>
					<p><strong><?php __d('raffles', 'Your prize: '); ?></strong> <?php echo $result['Prize']['title']; ?></p>
					<p><strong><?php __d('raffles', 'Sponsored by: '); ?></strong> <?php echo $result['Prize']['sponsor']; ?></p>
				<?php else: ?>
					<h2><?php __d('raffles', 'Sorry. Try again'); ?></h2>
					<p><?php printf(__d('raffles', 'The number <strong>%s</strong> has no prize', true), $ticket) ?></p>
				<?php endif ?>
			<?php else: ?>
		<fieldset>
			<?php endif ?>
				<?php echo $this->Form->create('Prize'); ?>
				<div class="row">
					<?php
					echo $this->FForm->input('Prize.number', array(
						'label' => __d('raffles', 'Ticket number', true)
					));
					?>
				</div>
				<?php echo $this->FForm->end(array(
					'returnTo' => '/',
					'discard' => false,
					'saveAndWork' => false,
					'saveAndDone' => __d('raffles', 'Check your ticket', true)
				)); ?>			</fieldset>
		</div>
		<div class="medium-4 column">
			<?php echo $this->Page->block('/raffles/sponsors'); ?>
		</div>

	</div>
</article>