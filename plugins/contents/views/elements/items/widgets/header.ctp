<?php	
	$template = 'full';
	
	if (!$this->Image->value('path')) {
		$template = 'plain'; 
	}
	
	echo $this->Page->block('/ui/headers/'.$template, array(
		'title' => $this->Item->value('title'),
		'tagline' => $this->Item->value('tagline'),
		'image' => $this->Image->value('path'),
		'icon' => $this->Channel->value('icon'),
		'author' => $this->Authors->toList('realname'),
		'imageOptions' => array(
			'size' => 'itemMainImage',
			'filter' => array('blur' => 10)
		),
		'url' => $this->Channel->selfUrl(),
		'parent' => $this->Channel->value('title')
	));
	
	
	// echo $this->Block->pageTitle($options);
?>
