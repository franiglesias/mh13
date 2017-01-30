<?php
/**
 * License
 * 
 * An item-widget to display license information
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
		<h1><?php __d('contents', 'Licensing'); ?></h1>
	</header>
	<div class="body">
		<?php echo $item['License']['code']; ?>
	</div>
</aside>
