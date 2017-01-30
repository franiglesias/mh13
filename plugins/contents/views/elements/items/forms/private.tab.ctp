<div class="content" id="tabs-access">
	<fieldset id="tabs-5">
		<legend><?php __d('contents', 'Private Item') ?></legend>
		<div class="row">
			<div class="medium-6 columns">
				<div class="row">
					<?php
						echo $this->FForm->help(null,
						__d('contents', 'If you want to restrict access to this Item, create a pair User/password to lock it, and pass them along to the authorized visitor you want to allow read the Item.', true),
						__d('contents', 'If you want to turn the item Public again, simply clear the user and password data.', true)
					);

					?>
				</div>
			</div>
			<div class="medium-6 columns">
				<div class="row">
					<?php
						echo $this->FForm->input('guest', array(
							'label' => __d('contents', 'User', true),
							'help' => __d('contents', 'User name for the authorized visitors.', true)
						));
						echo $this->FForm->input('guestpwd', array(
							'label' => __d('contents', 'Password', true),
							'help' => __d('contents', 'Password for the authorized visitors.', true)
						));
					?>
				</div>
			</div>
		</div>
	</fieldset>
	
</div>
