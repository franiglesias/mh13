<?php
/**
 * Menu
 * 
 * Displays a menu as a list into a nav section.
 * 
 * @param string $menu The label of the menu
 * @param boolean $title if true display the title of the menu
 * 
 * @package menus.milhojas13
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/

if (!isset($menu)) {
	throw new InvalidArgumentException('No menu name provided for /menus/menu');
}

if (!isset($title)) {
	$title = __('Filter', true);
}

if (!isset($class)) {
	$class = 'top-bar';
} else {
	$class = 'top-bar '.$class;
}

if (!isset($itemClass)) {
	$itemClass = false;
}

$data = $this->requestAction(array(
		'plugin' => 'menus',
		'controller' => 'menus',
		'action' => 'items',
		),
		array('pass' => array($menu))
	);
	
if (empty($data['MenuItem'])) {
	return;
}

if (!isset($id)) {
	$id = strtolower($data['Menu']['title']).'-menu';
}

$title = '';

if (isset($pageHeader)) {
	// Build Channel link
	$icon = '';
	$label = $pageHeader['title'];
	if (!empty($pageHeader['icon'])) {
		$icon = $this->Media->image($pageHeader['icon'], array(
			'size' => 'menuIcon',
			'attr' => array('class' => 'mh-channel-menu-home-icon')
			)
		);
		$label = $icon;
	}
	$title = $this->Html->link($label, $pageHeader['url'], array('escape' => false));
}



?>


<nav class="<?php echo $class; ?>" id="<?php echo $id ?>" data-topbar>
  <ul class="title-area">
    <li class="name">
	<?php if ($title): ?>
      <h1><a href="#"><?php echo $title; ?></a></h1>
	<?php endif; ?>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Left Nav Section -->
    <ul class="left">
	<?php foreach ($data['MenuItem'] as $item): ?>
		<li class="tab-title"><?php echo $this->Html->link(__d('menus', $item['MenuItem']['label'], true), $item['MenuItem']['url']); ?></dd>
	<?php endforeach ?>
    </ul>
  </section>
</nav>
