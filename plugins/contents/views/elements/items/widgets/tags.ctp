<?php
/**
 * Tags
 * 
 * An item-widget to display tags for this item
 *
 * @package widgets.items.elements.views.contents.milhojas
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 * @param $item array
 * 
 * 
 **/

?>
<aside class="mh-widget">
	<header>
		<h1><?php __d('contents', 'Tags') ?></h1>
	</header>
	<div class="body">
	<?php if (empty($item['Label'])): ?>
		<p><?php __d('contents', 'This item hasn\'t been tagged yet'); ?></p>
	<?php else: ?>
		<?php foreach ($item['Label'] as $tag): ?>
			<p class="mh-tag"><?php echo $this->Html->link(
				$tag['Label']['title'],
				array(
					'plugin' => 'contents',
					'controller' => 'channels',
					'action' => 'tagged',
					$item['Channel']['slug'],
					$tag['Label']['id']
				), array(
					'class' => ''
				)); ?></p>
		<?php endforeach ?>
	<?php endif ?>
		
	</div>
</aside>
