<?php
/**
 * /contents/channels/list
 * 
 * Shows a list of channels. 
 * If 'site' param is passed filters the list to the channels in that site
 * If 'site' is empty or not passed, then list all channels
 * 
 * Relays in /contents/channels/menu[/site]
 * 
 * @param site (string) The key for the site
 * 
 */
	$defaults = array(
		'options' => array(
			'class' => 'mh-footer-menu', 
			'id' => 'mh-channel-list'
		)
	);
	
	if (isset($options)) {
		$options = Set::merge($defaults, $options);
	} else {
		$options = $defaults;
	}

	$channels = $this->requestAction(array(
		'plugin' => 'contents',
		'controller' => 'channels',
		'action' => 'external'
		)
	);
	
	$data = array(
		'title' => __d('contents', 'Channels', true),
		'items' => array()
	);
	
	$code = array();
	
	foreach ($channels as $channel) {
		$class = '';
		if (!empty($channel['Channel']['restricted'])) {
			$class = 'fi-lock';
		}

		$label = $this->Html->tag('span', $channel['Channel']['title'], array('class' => $class));
		
		$url = array(
			'plugin' => 'contents',
			'controller' => 'channels',
			'action' => 'view',
			$channel['Channel']['slug']
			);
			
		$icon = $channel['Channel']['icon'];
		
		if (empty($icon)) {
			$icon = Configure::read('Site.icon');
		}
		
		if (!empty($icon)) {
			$icon = $this->Media->image($icon, array('size' => 'menuIcon', 'attr' => array('class' => 'mh-media-object')));
			$label = $icon.$label;
		}
		
		$item = $this->Html->link($label, $url, array('escape' => false));
		$code[] = $item;
	}
	
?>

<ul class="small-block-grid-1 medium-block-grid-4 large-block-grid-6">
	<?php foreach ($code as $line): ?>
		<?php echo $this->Html->tag('li', $line, array('class' => 'mh-footer-channel-menu-item')); ?>
	<?php endforeach ?>
</ul>