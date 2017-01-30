<section id="resources-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php printf(__('Search %s', true), __d('resources', 'Resources', true)); ?></h1>
		<p class="mh-admin-panel-menu">
		<?php echo $this->Html->link(
			__('Admin', true), 
			array('action' => 'index'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-admin')
		); ?> 
		<?php echo $this->Html->link(
			__d('resources', 'Search', true), 
			array('action' => 'search', 'new'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-search')
		); ?>
		</p>
	</header>
	<div class="mh-admin-panel-body container">
		<div class="column col2of5">
		<?php
			echo $this->Form->create(null, array(
				'url' => array('plugin' => 'resources', 'controller' => 'resources', 'action' => 'search'),
				 'class' => 'mh-inline-form'
			));
			echo $this->Form->input('Sindex.term', array(
				'label' => __('Terms to find', true),
				'class' => 'input-long'
			));
			echo $this->Form->input('Resource.subject_id', array(
				'empty' => true,
				'options' => $subjects
			));
			echo $this->Form->input('Resource.level_id', array(
				'empty' => true,
					'options' => $levels
			));
			
			echo $this->Form->end(array('label' => __('Search', true)));
		?> 
		</div>
		<div class="column col3of5 last-column story">
			<header class="header story-header">
				<h1 class="heading story-heading">Cómo localizar recursos</h1>
			</header>
			<div class="story-body">
				<p>Puedes localizar recursos digitales utilizando palabras clave. El sistema buscará los recursos que las contengan en el título, la descripción o las etiquetas, siempre y cuando tengan más de tres letras.</p>
				<p>Puedes combinar varias palabras clave para realizar búsquedas más complejas.</p>
				<h3>Recursos que contengan cualquiera de las palabras</h3>
				<p>Escribe las palabras clave separadas por espacios. Por ejemplo:</p>
				<p><strong>matemáticas</strong> <strong>ciencias</strong></p>
				<p>Localizará recursos que contengan o bien la palabra <strong>matemáticas</strong>, o bien <strong>ciencias</strong>, o bien <strong>ambas</strong>.</p>
				<h3>Recursos que contengan todas las palabras indicadas</h3>
				<p>Añade cada palabra clave extra precedida de un signo + para hacer que el sistema busque aquellos recursos que contengan todas las palabras clave indicadas. Por ejemplo:</p>
				<p><strong>Matemáticas</strong> <strong>+fraccione</strong>s</p>
				<p>Localizará los recursos que contengan ambas palabras, pero no los que sólo contengan una de ellas.</p>
				<h3>Recursos que no contengan ciertas palabras</h3>
				<p>Para excluir de la búsqueda algunas palabras clave, añádelas precedidas de un signo -. Por ejemplo:</p>
				<p><strong>Matemáticas</strong> <strong>-fracciones</strong></p>
				<p>Localizará recursos de <strong>matemáticas</strong> que no contengan la palabra <strong>fracciones</strong>.</p>			
				
			</div>
		</div>

		
	</div>
</section>