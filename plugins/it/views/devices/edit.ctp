<?php
	$this->Device->bind($this->data);
	$populate = Router::url(array(
		'plugin' => 'it',
		'controller' => 'devices',
		'action' => 'device',
		$this->data['Device']['id']
	));
	// if ($this->data['Device']['status'] != 2) {
	// 	echo $this->Html->link(
	// 		__d('it', 'Retire Device', true), 
	// 		array('action' => 'retire', $this->Form->value('Device.id')), 
	// 		array(
	// 			'class' => 'mh-button mh-admin-panel-menu-item mh-button-cancel mh-admin-panel-menu-item-alt',
	// 			'confirm' => sprintf(__('Are you sure you want to retire %s?', true), $this->Form->value('Device.title'))
	// 				)
	// 		);
	// }
?>
<section id="devices-edit" class="mh-admin-panel">
	<header>
		<h1>
			<?php
				echo $this->Backend->editHeading($this->data, 'Device', 'it', $this->Form->value('Device.title'));
			?> 
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo $this->Form->create('Device', array('type' => 'file'));?> 
		<fieldset>
			<legend><?php __d('it', 'Device'); ?></legend>
			<?php if ($this->data) echo $this->Form->input('id'); ?>
			<?php
				echo $this->FForm->input('status', array(
					'type' => 'hidden'
				));
			?>
			<div class="row">
				<?php
				echo $this->FForm->select('device_type_id', array(
					'label' => __d('it', 'Device type', true),
					'options' => $deviceTypes,
					'div' => 'medium-3 columns'
				));
				echo $this->FForm->input('title', array(
						'label' => __d('it', 'Device name', true),
						'div' => 'medium-4 columns'
					));
				echo $this->FForm->input('status_label', array(
					'label' => __d('it', 'Device status', true),
					'value' => $this->Device->statuses[$this->Form->value('status')],
					'readonly' => true,
					'div' => 'medium-4 columns end'
				));
			
				?>
			</div>
			<div class="row">
				<?php
					echo $this->FForm->textarea('status_remark', array(
						'label' => __d('it', 'Status remarks', true),
						'rows' => 3,
						'div' => 'medium-6 columns'
					));
					echo $this->FForm->textarea('remarks', array(
						'label' => __d('it', 'Device remarks', true),
						'rows' => 3,
						'div' => 'medium-6 columns'
					));
			
				?>
			</div>
		
		</fieldset>
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#tabs-1"><?php __d('it', 'Maintenance Actions'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('it', 'Device Details'); ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('it', 'Maintenance Actions' ); ?></legend>		
					<?php if ($this->Form->value('Device.id')): ?>
					
						<div class="panel radius clearfix">	
							<div id="maintenances-list">
								<?php
									$maintenances = $this->requestAction(
										array('plugin' => 'it', 'controller' => 'maintenances', 'action' => 'index'),
										array('return', 'pass' => array(0 => $this->Form->value('Device.id')))
									);
									echo $maintenances;
								?>
							</div>
							<?php 
								$addUrl = Router::url(array(
									'plugin' => 'it', 
									'controller' => 'maintenances', 
									'action' => 'add', 
									$this->Form->value('Device.id')
									), 
									true
								);
								echo $this->FForm->ajaxAdd($addUrl, array('childModel' => 'Maintenance', 'focus' => 'Maintenance.description')); 
							?>
						</div>		
					<?php endif ?>
				</fieldset>			
			</div>
			<div class="content" id="tabs-2">
				<fieldset>
					<legend><?php __d('it', 'Device details'); ?></legend>
					<div class="row">
						<?php
							echo $this->FForm->input('identifier', array(
								'label' => __d('it', 'Identifier', true),
								'div' => 'medium-3 columns'
							));
							echo $this->FForm->input('mac', array(
								'label' => __d('it', 'MAC address', true),
								'div' => 'medium-3 columns'
							));
							echo $this->FForm->input('location', array(
								'label' => __d('it', 'Location', true),
								'div' => 'medium-4 columns end'
							));
						?>
					</div>
					<div class="row">
						<?php
							echo $this->FForm->input('vendor', array(
								'label' => __d('it', 'Vendor', true),
								'div' => 'medium-3 columns'
							));
							echo $this->FForm->input('model', array(
								'label' => __d('it', 'Model', true),
								'div' => 'medium-4 columns'
							));
							echo $this->FForm->input('serial', array(
								'label' => __d('it', 'Serial number', true),
								'div' => 'medium-4 columns end'
							));
						
						?>
					</div>
					<div class="row">
						<?php
						echo $this->FForm->image('image', array(
							'label' => __d('it', 'Image', true),
							'div' => 'medium-6 columns end'
						));
						?>
					</div>
					
				</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
<!-- Modal -->
<div id="maintenance-form" class="reveal-modal" data-reveal mh-url="<?php echo $populate; ?>"></div>