<?php 
	$this->Circular->link($this->Event, 'Event');
	$this->Circular->setLanguage(Configure::read('Config.language'));
	$this->Event->setLanguage(Configure::read('Config.language'));
	$this->Page->title(__d('circulars', 'Circular', true).' '.$this->Circular->value('title'));
?>
<article class="mh-page">
	<div class="columns">
		<header>
			<h2><?php echo $this->Circular->value('addressee'); ?></h2>
			<h1><?php printf('%s: %s', $circular['CircularType']['title'], $this->Circular->value('title')); ?></h1>
		</header>
		<div class="body">
			<?php echo $this->Circular->format('content', 'html'); ?>
			<?php echo $this->element('circulars/'.$circular['CircularType']['template'].'/web', array('plugin' => 'circulars')); ?>
			<p><a href="https://www.jesuitinas.net/miralba/alumno/login.asp">Consulta la Plataforma educativa para más información.</a></p>
		</div>
	</div>
</article>

