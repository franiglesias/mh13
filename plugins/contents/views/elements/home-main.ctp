<?php 
$defaults = array(
	// Data for Request Action
	
	'offset' => 0,					// Pagination option
    'limit' => Configure::read('Theme.limits.page'),			// Pagination option
	'siteName' => null,					// Site to retrieve data
	'channelList' => null,			// Channels from where retrieve data
	'paginate' => false,			// If true paginate results. False use a find('all'). 
	'sticky' => true,				// Take care of sticky items
	'featured' => false,			// Only retrieve featured
	'excludePrivate' => false, 		// Exclude private content
	'exclude' => false,				// Channels to exclude
	'home' => false,				// Only items marked for home page
	'tag' => false,
	'label' => false,
	
	// Select catalog
	
	'template' => 'feed',
	'layout' => 'list',
	'engine' => 'List',
	'title' => 'Items collection',
	'footer' => ''
);

extract($defaults, EXTR_SKIP);
$items = $this->RequestAction(
	array(
		'plugin' => 'contents',
		'controller' => 'items',
		'action' => 'catalog'
		),
	array(
		'named' => compact(
				'offset',
				'limit',
				'siteName',
				'channelList',
				'paginate',
				'sticky',
				'featured',
				'exclude',
				'excludePrivate',
				'home',
				'tag',
				'label'
				)
	)
);

if (!$items) {return;}

$this->Items->bind($items);
$this->Items->attach($this->Item);
$this->Items->next();

$B = LayoutFactory::get($engine, $this->Items);
echo $B->withTitle($title)
		->usingLayout($layout)
		->usingTemplate($template)
		->withFooter($footer)
		->render();
?>
