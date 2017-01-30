<?php
/**
 * Blog
 * 
 * An item-widget to display blog information
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
		<h1><?php __d('contents', 'Abstract'); ?></h1>
	</header>
	<div class="body">
		<p><?php echo $this->Item->format('content', 'excerpt', 50); ?></p>
	</div>
</aside>