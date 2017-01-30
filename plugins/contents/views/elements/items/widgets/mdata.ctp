<?php
/**
 * Meta data
 * 
 * An item-widget to display metadata information about the item
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
		<h1><?php __d('contents', 'This article has'); ?></h1>
	</header>
	<div class="body">
		<ul class="mh-metadata">
			<li class="fi-link"><?php echo $this->FHtml->permalink($this->Item); ?></li>
			<li class="fi-calendar"><?php echo $this->Item->format('pubDate', 'date'); ?></li>
			<li class="fi-alert"><?php echo $this->Item->format('expiration', array('empty' => 'no', 'shortDate' => true)); ?></li>
			<li class="fi-photo"><a href="#mh-images"><?php echo $this->Item->format($this->Images->count(), 'string', __d('contents', '%s images', true)); ?></a></li>
			<li class="fi-video"><a href="#mh-multimedia"><?php echo $this->Item->format($this->Item->countKey('Multimedia'), 'string', __d('contents', '%s multimedia', true)); ?></a></li>
			<li class="fi-download"><a href="mh-downloads"><?php echo $this->Item->format($this->Item->countKey('Download'), 'string', __d('contents', '%s downloads', true)); ?></a></li>
			<li class="fi-eye" id="mh-item-readings"><?php echo $this->Item->format('readings', 'string', __d('contents', 'Read %s times', true)); ?></li>
		</ul>
	</div>
	<script>
	$(function(){
	    $("#mh-item-readings").load("<?php echo Router::url(array(
			'plugin' => 'contents',
			'controller' => 'items',
			'action' => 'readings',
			$this->Item->value('id')
			)
		); ?>");
	});
	</script>
</aside>