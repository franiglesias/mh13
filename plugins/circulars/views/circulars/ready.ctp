<section id="circulars-index" class="mh-admin-panel">
	<header>
		<h1><?php __d('circulars', 'Ready');?>
			<span class="right">
			<?php echo $this->Html->link(
				__('Admin', true), 
				array('action' => 'index'), 
				array('class' => 'mh-btn-index')
			); ?> 
			</span>
		</h1>
	</header>
	<?php if (!empty($generateFile)): ?>
		<?php //echo $this->element('../circulars/pdf/view', array(compact('circular', 'assets'))); ?>
	<?php endif; ?>
	<div class="mh-admin-panel-body">
		<p class="mh-message mh-info"><?php printf(__d('circulars', 'Circular %s, with title "%s" has been successfully set to <strong>%s</strong>', true), $this->Circular->value('id'), $this->Circular->mixValue('title'), $this->Circular->statusOptions[$this->Circular->value('status')]); ?></p>
		<p><?php echo $this->Html->link(
			__d('circulars', 'Return to circulars', true),
			array('action' => 'index'),
			array('class' => 'mh-btn-ok')
		) ?></p>
	</div>
</section>