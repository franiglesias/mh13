<?php
	$data = $this->requestAction(
		array('plugin' => 'cantine',
			'controller' => 'cantine',
			'action' => 'today'
			)
		);
?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-record"><?php __d('cantine', 'Cantine Menu for Today'); ?></h1>
	</header>
	<div class="body">
	<?php if (empty($data)): ?>
		<?php echo $this->Page->block('/ui/nocontent', array('message' => __d('cantine', 'No cantine service today', true))); ?>
	<?php else: ?>
		<ul class="mh-catalog-list"><?php
		$text = $data[0]['CantineWeekMenu']['CantineDayMenu'][$data['weekDay']-1]['menu'];
		if (!empty($data['Remark'][$data['date']])) {
			$text = $data['Remark'][$data['date']];
		}
		$cell = preg_replace('/^.*$/m', "<li>$0</li>", $text);
		echo $cell;
		?></ul>
	<?php endif ?>
	</div>

	<?php if ($this->params['plugin'] !== 'cantine'): ?>
	<footer>	
		<?php echo $this->Html->link(__d('cantine', 'Go to cantine', true), array(
			'plugin' => 'cantine',
			'controller' => 'cantine',
			'action' => 'home'
			),
			array('class' => 'mh-btn-index')
		); ?>
	</footer>
	<?php endif ?>
</aside>