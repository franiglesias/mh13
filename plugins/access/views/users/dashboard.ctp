<div class="mh-admin-panel">
	<header>
		<h1>
			<?php printf(__d('access', 'Hello, %s. This is your dashboard', true), $this->Session->read('Auth.User.realname')); ?>
		</h1>
	</header>
	<div>
		<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
		<?php
		foreach ($dashboards as $dashboard) {
			echo $this->Html->tag('li', $this->Page->block($dashboard));
		}
		?>
		</ul>
	</div>
</div>
