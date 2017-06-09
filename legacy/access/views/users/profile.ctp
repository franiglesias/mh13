<?php
$this->FForm->defaults['labelPosition'] = 'inline';
$this->FForm->defaults['labelSize'] = 2;
?>
<section id="menus-edit" class="mh-admin-panel">
	<header>
		<h1><?php printf(__d('access', '%s, Edit your profile', true), $this->Form->value('User.realname')); ?></h1>
	</header>
	<div class="mh-admin-panel-body">
	<?php echo $this->Form->create('User', array('type' => 'file'));?>
		
		<dl class="tabs" data-tab>
			<dd class="active"><a href="#tabs-1"><?php __d('access', 'Account'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('access', 'Profile'); ?></a></dd>
			<dd><a href="#tabs-3"><?php __d('access', 'Stats'); ?></a></dd>
		</dl>
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('access', 'Account data'); ?></legend>
					<?php if ($this->data) {echo $this->Form->input('id');} ?>
					<div class="row">
						<?php
							echo $this->FForm->input('username', array(
								'label' => __d('access', 'User name', true),
								'div' => 'small-12 medium-4 columns',
								'help' => __d('access', 'Name for the access account.', true)
								)
							);
							echo $this->FForm->input('realname', array(
								'label' => __d('access', 'Real name', true),
								'div' => 'small-12 medium-4 columns',
								'help' => __d('access', 'Real name of the user, to show in the screen.', true)
								)
							);
							echo $this->FForm->email('email', array(
								'label' => __d('access', 'Email', true),
								'div' => 'small-12 medium-4 columns',
								'help' => __d('access', 'To contact the user.', true)
								)
							);
						?>
					</div>
					<div class="row">
						<div class="small-12 medium-2 columns">
							<?php echo $this->Html->link(
							__d('access', 'Change password', true),
							'javascript:void(0);',
							array('onclick' => "$('#mh-profile-change-password').toggle();",
								'class' => 'button small radius'
								)
							); ?>
						</div>
						<?php echo $this->FForm->help(
							'small-12 medium-10 columns',
							sprintf(__d('access', 'To change your password, click on the <strong>%s</strong> button and type the new password and a confirmation.', true), __d('access', 'Change password', true)),
							sprintf(__d('access', 'It will be saved when you click on the <strong>%s</strong> button. and will take effect in your next login.', true), __('Save and Done', true)
							)); ?>
					</div>
					<div class="row" id="mh-profile-change-password" style="display: none;">
						<?php
							echo $this->FForm->password('password', array(
								'label' => __d('access', 'Password', true),
								'div' => 'small-12 medium-6 columns',
								'help' => __d('access', 'Keep this password secret. The longer, the better. On edit leave blank to keep unmodified.', true)
								)
							);
							echo $this->FForm->password('confirm_password', array(
								'label' => __d('access', 'Confirm Password', true),
								'div' => 'small-12 medium-6 columns',
								'help' => __d('access', 'Retype the password to be sure.', true)
								)
							);
						?>
					</div>	
				</fieldset>
			</div>
			<div class="content" id="tabs-2">
				<fieldset>
					<legend><?php __d('access', 'Profile'); ?></legend>
					<div class="row">
					<?php
					echo $this->FForm->image('photo', array(
						'image' => $this->data['User']['photo'],
						'inputSize' => 12,
						'label' => __d('access', 'Photo', true),
						'help' => __d('access', 'Photograph with centered face (will be framed).', true)
						)
					);
					echo $this->FForm->textarea('bio', array(
						'label' => __d('access', 'Brief Biography', true),
						'div' => 'small-12 medium-12 columns',
						'help' => __d('access', 'A paragraph or two.', true)
						)
					);
					?></div>
				</fieldset>
			</div>
			<?php if (!empty($this->data)): ?>
			<div class="content"  id="tabs-3">
				<fieldset>
					<legend><?php __d('access', 'Current status'); ?></legend>
					<p class="input"><?php
							if ($this->Form->value('connected')) 
							{
								__d('access', 'User is online');
							} else {
								__d('access', 'User is offline');
							}
						?>
					</p>
					<p class="input">
					<?php
						if ($this->Form->value('last_login')) {
							printf(__d('access', 'Last login was the %s', true), $this->Time->i18nFormat($this->Form->value('last_login')));
						} else {
							__d('access', 'Never connected yet');
						}
					?>
					</p>
				</fieldset>
			</div>
			<?php endif; ?>
		</div>
		
		<?php echo $this->Form->end(array('label' => sprintf(__('Submit %s', true), __d('access', 'Profile', true)), 'class' => 'mh-btn-ok right', 'div' => array('class' => 'submit fixed-submit')));?>
	</div>
</section>