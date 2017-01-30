<?php
/**
 * Retrieve data for the dashboard panel
 */
	$devices = $this->requestAction(array('plugin' => 'it', 'controller' => 'devices', 'action' => 'dashboard'));
	
	App::import('Helper', 'It.Device');
	App::import('Helper', 'It.Devices');
	$this->Devices = new DevicesHelper();
	$this->Devices->setDataProviderFactory(ClassRegistry::init('DataProviderFactory'));
	$this->Devices->setView(ClassRegistry::getObject('View'));
	$this->Device = new DeviceHelper();

	$this->Devices->bind($devices)->attach($this->Device);

?>
<div class="mh-dashboard-widget">
<header>
	<h1 class="fi-laptop">
		<?php __d('it', 'IT Devices with problems'); ?>
		<span>
			<?php printf(__d('access', '# %s', true), $this->Devices->count()); ?>
		</span>
	</h1>
</header>

<div>
<?php if ($this->Devices->count()): ?>
	<ul class="mh-dashboard-list">
		<?php while ($this->Devices->hasNext()): ?>
		<?php $this->Devices->next(); ?>
		<li><?php echo $this->Device->dashboard(); ?></li>
		<?php endwhile ?>
	</ul>
<?php else: ?>
	<?php echo $this->Page->block('/ui/nocontent', array(
		'message' => __d('it', 'All registered devices are working OK.', true)
	)); ?>
<?php endif; ?>
</div>

<footer>
	<ul class="mh-dashboard-legend">
		<li><p class="mh-allowed"><?php __d('it', 'Maintenance started'); ?></p></li>
		<li><p class="mh-limited"><?php __d('it', 'In repairing'); ?></p></li>
		<li><p class="mh-forbidden"><?php __d('it', 'Retired'); ?></p></li>
	</ul>
</footer>
</div>