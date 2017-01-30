<?php
	$this->Page->title(Configure::read('Site.title').': '.Configure::read('Site.tagline'));
	$site = 'noticias'; // Move to a preference
	echo $this->XHtml->rssLink(__('Site feed', true));
	
?>
<div class="mh-page">
<div id="home-main-column" class="medium-8 columns" data-equalizer-watch>
	<ul id="mh-home-page-tabs" class="tabs" data-tab>
	  <li class="tab-title active"><a href="#mh-news">Noticias</a></li>
	  <li class="tab-title"><a href="#mh-anuncios">Tablón de anuncios </a></li>
	  <li class="tab-title"><a href="#mh-resto">Todas las novedades</a></li>
	</ul>
	<div class="tabs-content">
	  <div class="content active" id="mh-news">
		<?php echo $this->Page->block('/contents/home-main', array(
			'siteName' => Configure::read('Home.main'),
			'excludePrivate' => true,
			'sticky' => true,
			'engine' => 'List',
			'layout' => 'items/layouts/feed',
			'template' => 'items/templates/combifeed',
			'title' => 'Últimas noticias',
			'cache' => array(
				'time' => '+1 day',
				'key' => '-mh-contents-news-'
			)
		)); ?>
 	  </div><!--#mh-news-->
	  <div class="content" id="mh-anuncios">
		<?php echo $this->Page->block('/contents/home-main', array(
			'channelList' => Configure::read('Home.announces'),
			'sticky' => true,
			'layout' => 'items/layouts/feed',
			'template' => 'items/templates/feed',
			'title' => 'Anuncios recientes',
			'cache' => array(
				'time' => '+1 day',
				'key' => '-mh-contents-announces-'
			)
		)); ?>
	  </div> <!--#mh-anuncios-->
	  <div class="content" id="mh-resto">
		<?php echo $this->Page->block('/contents/home-main', array(
			'exclude' => Configure::read('Home.newContentExclude'),
			'sticky' => false,
			'layout' => 'items/layouts/feed',
			'template' => 'items/templates/combifeed',
			'excludePrivate' => true,
			'title' => 'Últimos artículos',
			'cache' => array(
				'time' => '+1 day',
				'key' => '-mh-contents-new-content-'
			)
			)); ?>
	  </div> <!-- mh-resto-->
	</div>
</div>



<div id="home-navigation-column" class="medium-4 columns" data-equalizer-watch>
	<?php echo $this->Page->block('/menus/social', array(
		'cache' => '+7 days'
	)); ?>
	<?php echo $this->Page->block('/uploads/collection', array(
		'slug' => 'concertada', 
		'columns' => 1,
		'width' => '480',
		'cache' => array('time' => '+3 week', 'key' => '-mh-images-collection-concertada-'),
		'type' => 'bx',
		'classes' => array('widget' => 'mh-widget-alt'),
		'id' => 'ec-concertada',
		'intro' => '<a href="http://www.concertados.edu.es">En colegios también puedes elegir</a>'
		)); ?>
	
	<?php echo $this->Page->block('/circulars/events/next', array(
		'cache' => '+2 days'
	)); ?>
	<?php echo $this->Page->block('/cantine/today', array(
		'cache' => '+12 hour'
	)); ?>
	<?php echo $this->Page->block('/uploads/collection', array(
		'slug' => 'programas', 
		'columns' => 1,
		'width' => '480',
		'cache' => array('time' => '+3 week', 'key' => '-mh-images-collection-programas-'),
		'type' => 'column',
		'classes' => array('widget' => 'mh-widget-alt'),
		'id' => 'miralba-programas',
		'intro' => 'Certificaciones educativas'
		)); ?>
	<?php echo $this->Page->block('/circulars/circulars/current', array(
		'cache' => '+2 days'
	)); ?>
	<?php echo $this->Page->block('miralba/proyectos'); ?>
</div>

</div>