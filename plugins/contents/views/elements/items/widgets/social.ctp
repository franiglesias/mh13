<?php
/**
 * Social
 * 
 * An item-widget to display social links o share the items
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
		<h1><?php __d('contents', 'Share'); ?></h1>
	</header>
	<div class="body">
		<ul class="mh-share">
		<li><a href="JavaScript:window.open('http://www.facebook.com/sharer.php?u=<?php echo $this->Item->self(true); ?>','','width=657,height=400,scrollbars=1')" class="fi-social-facebook"><?php __('Like'); ?></a></li>
		<li><a href="JavaScript:window.open('https://twitter.com/share?url=<?php echo $this->Item->self(true); ?>&text=<?php echo $this->Item->value('title'); ?>','','width=450,height=350')" class="fi-social-twitter"><?php __('Twitt') ?></a></li>
		<li><a href="https://plus.google.com/share?url=<?php echo $this->Item->self(true); ?>" target="_blank" class="fi-social-google-plus"><?php __('Share'); ?></a></li>
		
		<li><a href="http://www.tumblr.com/share" title="Share on Tumblr" class="fi-social-tumblr"><?php __('Share'); ?></a></li>
		</ul>
	</div>
</aside>


