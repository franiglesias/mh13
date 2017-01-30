<?php
/**
 * /contents/items/all
 * 
 * Shows a list of items. 
 * 
 * Relays in /contents/channels/catalog
 * 
 * @param offset > offset to select items
 * @param limit max number of items to retrieve
 * @param site The site to get the items from
 * @param channel Channel id to get the items from
 * @param title string A title for the widget
 * @param sticky boolean Maintain featured items in the top of the list
 * @param paginate boolean Use Controller paginate method to retrieve items
 *
 * 
 */
		
		
	$defaults = array(
	    'limit' => Configure::read('Theme.limits.page'),
		'channel' => false,
		'site' => false,
		'offset' => 0,
		'sticky' => true,
		'title' => __d('contents', 'Recent entries', true),
		'paginate' => true,
		'exclude' => false,
		'excludePrivate' => false,
		'home' => false,
	    );

	extract($defaults, EXTR_SKIP);
	
	$items = $this->requestAction(
		array(
			'plugin' => 'contents',
			'controller' => 'items',
			'action' => 'catalog'
			),
		array(
			'named' => array(
				'limit' => $limit,
				'channel' => $channel,
				'site' => $site,
				'sticky' => $sticky,
				'offset' => $offset,
				'exclude' => $exclude,
				'excludePrivate' => $excludePrivate,
				'home' => $home
				)
			)
		);
		
		
		
?>
<section id="mh-contents-items-all" class="media entries">
	<header class="media-header entries-header">
		<h1 class="heading entries-heading"><?php echo $title; ?></h1>
	</header>
	<div class="media-body entries-body">
	<?php if (empty($items)): ?>
		<?php echo $this->element('nocontent', array('plugin' => 'Ui'));?>
		</section>
		<?php return; ?>
	<?php endif ?>
	<?php foreach ($items as $item): ?>
		<?php echo $this->Page->block('/contents/items/catalog_item', array('item' => $item)); ?>
	<?php endforeach ?>
	</div>
</section>