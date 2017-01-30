<?php if (empty($visitor['id'])): ?>
	<?php $this->Page->title(__d('resumes', 'Job zone', true)); ?>
	<header>
		<h1><?php __d('resumes', 'Would you like to work with us?'); ?></h1>
		<h2><?php __d('resumes', 'We are looking forward educators like you'); ?></h2>
	</header>
	<div class="body">
		<p>En el Colegio Miralba queremos conocerte. Buscamos personas inquietas por la Educación, preocupadas por dar lo mejor de sí para que los niños, niñas, adolescentes y jóvenes desarrollen al máximo su potencial.</p>
		<p>Si eres de quienes buscan que sus estudiantes se cuestionen, se pregunten, que miren el mundo con ojos nuevos cada día, que no se queden en la superficie y que disfruten aprendiendo, tenemos mucho de qué hablar.</p>
	</div>
	<div class="body">
		<ul class="small-block-grid-1 medium-block-grid-3">
			<li>
				<ul class="mh-pricing">
					<li class="title"><?php __d('resumes', 'Do you want to send us your CV?') ?></li>
					<li class="description">Puedes dejarnos tu currículum vitae y actualizarlo cuando lo desees. Lo tendremos en cuenta para futuras oportunidades laborales en el colegio.</li>
					<li class="cta-button"><?php echo $this->Html->link(
					__d('resumes', 'Create a resume', true),
					array('action' => 'create', 1),
					array('class' => "mh-btn-pricing")
					);
					?></li>
				</ul>
			</li>
			<li>
				<ul class="mh-pricing">
					<li class="title"><?php __d('resumes', 'Have you send us your CV and want to review it?') ?></li>
					<li class="description">Si ya nos has dejado tu currículum vitae pero quieres añadir nuevos logros.</li>
					<li class="cta-button"><?php echo $this->Html->link(
					__d('resumes', 'Modify your resume', true),
					array('action' => 'login'),
					array('class' => "mh-btn-pricing")
					);
					?></li>
				</ul>
			</li>
	
			<li>
				<ul class="mh-pricing">
					<li class="title"><?php __d('resumes', 'Have you forgot your password?') ?></li>
					<li class="description">Si has olvidado tus credenciales, puedes regenerar la contraseña usando esta utilidad.</li>
					<li class="cta-button"><?php echo $this->Html->link(
					__d('resumes', 'Reset your password', true),
					array('action' => 'forgot'),
					array('class' => "mh-btn-pricing")
					);
					?></li>
				</ul>		
			</li>
		</ul>
	</div>
<?php else: ?>
	<?php
	$this->set('title_for_layout', sprintf(__d('resumes', 'Resume management page for %s', true), $visitor['firstname'].' '.$visitor['lastname']));
	?>
	<header>
		<h1><?php __d('resumes', 'Your personal zone'); ?></h1>
		<h2><?php __d('resumes', 'Manage your resume here'); ?></h2>
	</header>
	<div class="body">
		<h3><?php __d('resumes', 'You are logged in with the following data:'); ?></h3>
		<p><?php printf(__d('resumes', 'Email: %s', true), $visitor['email']); ?></p>
		<p><?php printf(__d('resumes', 'Name: %s', true), $visitor['firstname'].' '.$visitor['lastname']); ?></p>
		<?php if ($completedProfile >= 95): ?>
		<h3><?php __d('resumes', 'Great! Your profile is complete.'); ?></h3>
		<?php else: ?>
		<h3><?php __d('resumes', 'Please, complete your personal and contact data'); ?></h3>
		<p><?php printf(__d('resumes', 'You have completed %.2f %% of your profile.', true), $completedProfile); ?></p>
		<div class="row">
			<div class="medium-8 columns">
				<div class="progress small-12 round <?php echo $completedProfile > 50 ? 'success' : 'alert'; ?>">
				  <span class="meter" style="width: <?php printf('%.2f%%', $completedProfile); ?>"></span>
				</div>
			</div>
			<div class="medium-4 columns">
				<?php echo $this->Html->link(
			__d('resumes', 'Go to Personal and contact data', true),
			array('plugin' => 'resumes', 'controller' => 'resumes', 'action' => 'modify'),
			array('class' => 'button tiny radius right')
			); ?>
			</div>
		</div>
		<?php endif ?>
		<h3><?php __d('resumes', 'Complete curriculum data into the following categories:'); ?></h3>
		<?php echo $this->Resume->stats($stats); ?>
	</div>
<?php endif ?>
