<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<section id="<?php echo $pluralVar;?>-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading">
			<?php echo
			"<?php
				echo \$this->Backend->editHeading(\$this->data, '{$modelClass}', 'domain', \$this->Form->value('{$modelClass}.{$displayField}'));
			?>"; ?> 
		</h1>
		<p class="mh-admin-panel-menu">
			<?php echo "<?php echo \$this->Html->link(
				__('Admin', true),
				\$this->data['App']['returnTo'],
				array('class' => 'mh-button mh-admin-panel-menu-item mh-button-back')
				);?>";?> 
			<?php echo "<?php if (\$this->data): ?>"; ?> 
				<?php echo "<?php echo \$this->Html->link(
					__('Delete', true), 
					array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), 
					array(
						'class' => 'mh-button mh-admin-panel-menu-item mh-button-cancel mh-admin-panel-menu-item-alt',
						'confirm' => sprintf(__('Are you sure you want to delete %s?', true), \$this->Form->value('{$modelClass}.{$displayField}'))
 						)
					); ?>";?> 
			<?php echo "<?php endif; ?>"; ?> 
		</p>
	</header>
	<div class="mh-admin-panel-body">
		<?php echo "<?php echo \$this->Form->create('{$modelClass}');?>"; ?> 
			<fieldset>
			<legend><?php echo "<?php __d('domain', '{$modelClass} Definition'); ?>"; ?></legend>
			<?php echo "<?php if (\$this->data) echo \$this->Form->input('id'); ?>"; ?>	
		<?php
				echo "\t<?php\n";
				foreach ($fields as $field) {
					if ($field == $primaryKey) {
						continue;
					} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
						echo "\t\t\t\techo \$this->Form->input('{$field}');\n";
					}
				}
				
				if (!empty($associations['hasAndBelongsToMany'])) {
					foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
						echo "\t\t\t\techo \$this->Form->input('{$assocName}');\n";
					}
				}
				echo "\t\t\t?>";
		?> 
		<?php echo "<?php echo \$this->Form->input('App.returnTo', array('type' => 'hidden')); ?>" ?>
		</fieldset>
		<?php echo "<?php echo \$this->Form->end(array(
			'label' => sprintf(__('Submit %s', true), __d('domain', '{$modelClass}', true)), 
			'class' => 'mh-button mh-button-ok', 
			'div' => array('class' => 'submit fixed-submit')
		));?>"; ?> 
	</div>
</section>