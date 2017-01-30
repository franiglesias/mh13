<nav id="mh-secondary-navigation" class="top-bar" data-topbar data-options="
  custom_back_text: false;
  mobile_show_parent_link: true
}">
	<ul class="title-area">
	    <li class="name">
	        <!--<h1><a href="" title="" rel="home"></a></h1>-->
	    </li>
	    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
	<?php echo $this->Page->block('/menus/bar', array(
	'bar' => 'main', 
	'title' => false, 
	'id' => 'mh-secondary-navigation',
	'search' => true,
	'cache' => array(
		'time' => '+1 week',
		'key' => 'secondary'.$this->Session->read('Auth.User.id')
		)
	)); ?>
	</section>
</nav>