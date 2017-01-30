<?php

$data = $this->requestAction(
	array('plugin' => 'contents',
	'controller' => 'channels',
	'action' => 'tags'
	),
	array('pass' => array($this->Channel->value('id')))
);

?>
<aside class="mh-widget">
	<header>
		<h1 class="fi-archive"><?php __d('contents', 'Tags'); ?></h1>
		<p><?php __d('contents', 'Tags provide a way to classify Items on a Channel.'); ?></p>
		<p><?php __d('contents', 'Click a Tag to see all Items with the same Tag.'); ?></p>
	</header>
	<div class="body">
		<?php if (!empty($data)): ?>
		<?php

			foreach ($data as $label) {
				$url = array(
					'plugin' => 'contents',
					'controller' => 'channels',
					'action' => 'tagged',
					$this->Channel->value('slug'),
					$label['Label']['id']
				);
				$link = $this->Html->link($label['Label']['title'], $url);
				echo $this->Html->tag('span', $link, array('class' => 'mh-tag'));
			}
		?>
		<?php endif; ?>
	</div>
</aside>