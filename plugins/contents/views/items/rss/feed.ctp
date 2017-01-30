<?php

$channel['description'] = strip_tags($channel['description']);
$this->set('channelData', $channel);
$this->Items->attach($this->Item);

while ($this->Items->hasNext()) {
	$this->Items->next();
	$this->Item->link($this->Authors, 'User');
	$this->Authors->attach($this->Author);
	$result = array(
		'title' => $this->Item->value('title'),
		'link' => $this->Item->selfUrl(),
		'guid' => array(
			'url' => $this->Item->selfUrl(),
			'isPermalink' => 'true'
		),
		'description' => $this->Item->format('content', 'clean'),
		'author' => $this->Authors->toRss(),
		'pubDate' => $this->Item->value('pubDate')
	);
	echo $this->Rss->item(array(), $result).chr(10);
}

// 	if (!empty($item['Enclosure'])) {
// 		$enclosure = array(
// 			'url' => Router::url('/'.$item['Enclosure']['path'], true),
// 			'length' => $item['Enclosure']['size'],
// 			'type' => $item['Enclosure']['type']
// 		);
// 		$result['enclosure'] = $enclosure;
// 	}
// 	echo $this->Rss->item(array(), $result).chr(10);
// }


?>