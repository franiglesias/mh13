<?php

$links = $meta = '';

if (isset($feed)) {
	$links = $this->Page->block('/aggregator/feeds/links', array('feed' => $feed, 'planet' => $feed['Planet']));
	$links .= $this->Page->block('/aggregator/planets/index', array('planet' => $feed['Planet'], 'feeds' => $feeds));
	$meta = $this->Page->block('/aggregator/feeds/metadata', array('feed' => $feed));
	$planet_id = $feed['Planet']['id'];
} elseif (isset($entry)) {
	$links = $this->Page->block('/aggregator/entries/links', array('feed' => $entry['Feed'], 'planet' => $entry['Feed']['Planet']));
	$links .= $this->Page->block('/aggregator/entries/feed', array('feed' => $entry['Feed']['slug']));

	$meta = $this->Page->block('/aggregator/entries/metadata', array('entry' => $entry));
	$planet_id = $entry['Feed']['Planet']['id'];
} elseif (isset($feeds)) {
	$links = $this->Page->block('/aggregator/planets/index', array('feeds' => $feeds));
	$planet_id = $planet['Planet']['id'];
} elseif (isset($planets)) {
	$links = $this->Page->block('/aggregator/planets/list', array('planet' => $planets));
	$planet_id = '';
}

$meta .= $this->Page->block('/aggregator/about');
$meta .= $this->Page->block('/aggregator/feeds/suggest', array('planet_id' => $planet_id));


$code = <<<HTML
<div class="row">
	<div class="medium-8 columns">
		{$content_for_layout}
	</div>
	<div class="medium-4 columns">
		{$links}
		{$meta}
	</div>
</div>
HTML;

echo $this->renderLayout($code, 'default');
?>

