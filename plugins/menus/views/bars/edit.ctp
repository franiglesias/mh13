<section id="bars-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Bar', 'domain', $this->Form->value('Bar.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Bar');?> 
		<fieldset>
			<legend><?php __d('domain', 'Bar Definition'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>	
			<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('menus', 'Title', true),
						'div' => 'small-12 medium-6 columns',
						'help' => __d('menus', 'An identification name', true)
					));
					echo $this->FForm->input('label', array(
						'label' => __d('menus', 'Label', true),
						'div' => 'small-12 medium-6 columns',
						'help' => __d('menus', 'A visible label', true)
					));
				?> 
			</div>
			<?php if ($this->Form->value('Bar.id')): ?>
			<div class="panel radius clearfix">
				<div id="menus-list">
					<?php
						$menus = $this->requestAction(
							array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'),
							array('return', 'pass' => array(0 => $this->Form->value('Bar.id')))
						);
						echo $menus;
					?>
				</div>
				<?php 
					$addUrl = Router::url(array(
						'plugin' => 'menus', 
						'controller' => 'menus', 
						'action' => 'bar', 
						$this->Form->value('Bar.id')
						), 
						true
					);
					echo $this->FForm->ajaxAdd($addUrl, array(
						'childModel' => 'Menu', 
						'class' => 'mh-btn-child-ok'
					)); 
				?>
			</div>
			<?php endif ?>
		</fieldset>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="menu-form" class="reveal-modal" data-reveal></div>