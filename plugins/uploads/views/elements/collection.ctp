<?php

App::import('Helper', 'Ui.Images');
App::import('Helper', 'Ui.Image');
App::import('Helper', 'Ui.Media');
$this->Images = new ImagesHelper();
$this->Images->setView($this);
$this->Images->setDataProviderFactory(new DataProviderFactory);
$this->Image = new ImageHelper();
$this->Image->Media = $this->Media;

$defaults = array(
    'slug' => false,
    'width' => 210,
    'height' => 210,
    'method' => 'fit',
	'type' => 'wall',
	'columns' => 1,
	'id' => 'mh-collection',
	'intro' => false
    );
   
extract($defaults, EXTR_SKIP);

$collection = $this->requestAction(
	array(
		'plugin' => 'uploads',
		'controller' => 'image_collections',
		'action' => 'collection',
		),
	array('pass' => array($slug))
	);

$this->Images->bind($collection['Image']);
$this->Images->attach($this->Image);

?>
<aside class="mh-widget" id="<?php echo $id; ?>">
	<?php if ($intro): ?>
		<header>
			<p><?php echo $intro; ?></p>
		</header>
	<?php endif ?>
	<div class="body">
		<?php echo $this->Images->gallery($type); ?>
	</div>
</aside>