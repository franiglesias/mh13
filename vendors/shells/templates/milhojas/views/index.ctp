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

echo "<?php
	\$options = array(
		'columns' => array(\n";
foreach ($fields as $field) {
	echo "\t\t\t'$field', ";
	echo chr(10);
}		
echo "\t\t),
		'actions' => array(
			'edit' => array('label' => __('Edit', true)),
			'delete' => array(
				'label' => __('Delete', true), 
				'confirm' => __('Are you sure?', true)
				)
			),
		'table' => array('class' => 'admin-table')
		);
?>";
?> 
<section id="<?php echo $pluralVar; ?>-index" class="mh-admin-panel">
	<header class="mh-admin-panel-header">
		<h1 class="heading mh-admin-panel-heading"><?php echo "<?php printf(__('Admin %s', true), __d('domain', '$pluralHumanName', true)); ?>"?></h1>
		<p class="mh-admin-panel-menu">
		<?php echo "<?php echo \$this->Html->link(
			__('Add', true), 
			array('action' => 'add'), 
			array('class' => 'mh-button mh-admin-panel-menu-item mh-button-ok mh-button-add')
		); ?>" ?> 
		</p>
		<?php echo "<?php echo \$this->element('paginator'); ?>"; ?> 
	</header>
	<div class="mh-admin-panel-body">
		<?php echo "<?php echo \$this->Table->render(\$$pluralVar, \$options); ?>"; ?> 
	</div>
</section>