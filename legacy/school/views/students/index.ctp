<section id="students-index" class="mh-admin-panel">
	<header>
		<h1><?php echo $this->Page->title(__d('school', 'Students', true), 'admin'); ?>
			<?php echo $this->Page->paginator(); ?></h1>
	</header>
	<div class="row">
		<div class="small-12 medium-3 columns">
			<div class="mh-admin-widget">
			<?php 
				echo $this->Html->link(sprintf(__('Add %s', true), __d('school', 'Student', true)),
					array('action' => 'add'),
					array('class' => 'mh-btn-create')
				);
				echo $this->Html->link(__d('school', 'Manage Sections', true),
					array('plugin' => 'school', 'controller' => 'sections', 'action' => 'index'),
					array('class' => 'mh-btn-people')
				);
			?>
			</div>
			<div class="mh-admin-widget">
			<?php
				echo $this->SimpleFilter->form();
				echo $this->SimpleFilter->contains('Student.fullname', array('label' => __d('school', 'Student', true)));
				echo $this->SimpleFilter->options('Student.section_id', array('options' => $sections, 'label' => __d('school', 'Section', true)));
				echo $this->SimpleFilter->options('Section.cycle_id', array('options' => $cycles, 'label' => __d('school', 'Cycle', true)));
				echo $this->SimpleFilter->options('Section.level_id', array('options' => $levels, 'label' => __d('school', 'Level', true)));
				// echo $this->SimpleFilter->swap('Student.extra1');
				echo $this->SimpleFilter->boolean('Student.extra2', array('label' => __d('school', 'Extra2', true)));
				echo $this->SimpleFilter->end();
			?>
			</div>
		</div>
		<div class="small-12 medium-9 columns">
			<?php echo $this->Students->adminTable(); ?>
		</div>
	</div>
</section>