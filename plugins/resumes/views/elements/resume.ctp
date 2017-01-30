<?php
$fields = array(
	'email' => array('label' => __d('resumes', 'Email', true), 'class' => 'email'),
	'phone' => array('label' => __d('resumes', 'Phone', true), 'class' => 'phone'),
	'mobile' => array('label' => __d('resumes', 'Mobile', true), 'class' => 'phone'),
	'fulladdress' => array('label' => __d('resumes', 'Address', true), 'class' => 'street-address'),
	'fullcity' => array('label' => __d('resumes', 'City', true), 'class' => 'locality')
);


?>
<div class="mh-resume">
	<div class="row">
		<div class="small-8 columns">
			<h1 class="mh-resume-title"><?php echo $resume['Resume']['firstname']; ?></br><?php echo $resume['Resume']['lastname']; ?></h1>
		</div>
		<div class="small-4 columns">
			<?php if ($resume['Resume']['photo']): ?>
				<?php echo $this->Media->image($resume['Resume']['photo'], array('size' => 'none', 'attr' => array('class' => ''))) ?>
			<?php endif ?>
		</div>
	</div>
	
	<div class="row">
		<div class="small-8 columns">
			<?php if (!empty($resume['Resume']['introduction'])): ?>
				<div class="mh-resume-introduction"><?php echo $resume['Resume']['introduction']; ?></div>
			<?php endif ?>
		</div>
		<div class="small-4 columns">
			<ul class="vcard">
			<?php foreach ($fields as $name => $field): ?>
				<li class="<?php echo $field['class']; ?>"><?php echo $resume['Resume'][$name]; ?></li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
	
	
	
	<?php foreach ($types as $key => $type): ?>
	<?php
		$lines = false;
		$title = $type['MeritType']['alias'];
		if (isset($resume[$title])) {
			$lines = $resume[$title];
		}
	?>
	<div class="row mh-resume-section">	
		<div class="small-4 columns">
			<h2 class="mh-resume-section-title"><?php echo $type['MeritType']['title']; ?></h2>
		</div>
		<div class="small-8 columns">
			<?php if (!$lines): ?>
				<div class="row"><p class="small-12 columns"><?php __d('resumes', 'There are no data for this section.'); ?></p></div>
			<?php else: ?>
				<?php foreach ($lines as $merit): ?>
				<div class="row">
					<?php if ($dates = $this->Resume->dates($merit)): ?>
						<div class="small-3 columns">
							<h3 class="mh-resumes-dates"><?php echo $dates; ?></h3>
						</div>
						<div class="small-9 columns">
							<?php echo $this->Resume->merit($merit); ?>
						</div>
					<?php else: ?>
						<div class="small-12 columns">
							<?php echo $this->Resume->merit($merit); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php endforeach ?>
			<?php endif ?>
		</div>
	</div>	
	<?php endforeach ?>
	
</div>