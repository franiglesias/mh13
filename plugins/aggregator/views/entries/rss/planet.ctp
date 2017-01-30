<?php
$channel['description'] = strip_tags($channel['description']);
$channel['atom:link'] = array('attrib' => array(
	'href' => Router::url(null, true),
	'rel' => 'self',
	'type' => 'application/rss+xml'
));
$this->set('channelData', $channel);
foreach ($items as $item) {
	$description = sprintf(__d('aggregator', '<p>Published by <a href="%s">%s</a></p>', true), $item['Feed']['url'], $item['Feed']['title']).$item['Entry']['content'];
	$description = Sanitize::stripTags($description, 'iframe', 'object', 'param', 'script');
	$result =  array(
	    'title' => $item['Entry']['title'],
	    'link'  => $item['Entry']['url'],
	   	'guid'  => $item['Entry']['guid'],
	   	'description' => $description,
		'pubDate' => $item['Entry']['pubDate'],
		'source' => array('url' => $item['Feed']['url'], 'title' => $item['Feed']['title'])
	);
	if (!empty($item['Entry']['email'])) {
		$result['author'] = $item['Entry']['email'];
	}
	if (!empty($item['Entry']['enclosure_url'])) {
		$result['enclosure'] = array(
			'url' => $item['Entry']['enclosure_url'],
			'length' => $item['Entry']['enclosure_length'],
			'type' => $item['Entry']['enclosure_type']
			);
	}
	echo $this->Rss->item(array(), $result);
}
?>