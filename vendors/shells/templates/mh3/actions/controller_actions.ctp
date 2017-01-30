<?php
/**
 * Bake Template for Controller action generation.
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
 * @subpackage    cake.console.libs.template.objects
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

	public function index() {
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

	public function view($id = null) {
		if (!$id) {
<?php if ($wannaUseSession): ?> 
			$this->Session->setFlash(sprintf(__('Invalid %s.', true), __d('domain', '<?php echo strtolower($singularHumanName); ?>', true)), 'flash_error');
			$this->redirect(array('action' => 'index'));
<?php else: ?> 
			$this->flash(sprintf(__('Invalid %s.', true), __d('domain', '<?php echo strtolower($singularHumanName); ?>', true)), array('action' => 'index'));
<?php endif; ?> 
		}
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}

<?php $compact = array(); ?>
	function <?php echo $admin ?>add() {
		$this->setAction('<?php echo $admin ?>edit');
	}

<?php $compact = array(); ?>

	public function edit($id = null) {
		// Data needed to load or reload model
		$fields = array('id','title');
		// Second pass
		if (!empty($this->data['<?php echo $currentModelName; ?>'])) {
			// Create model if there is no id (add action)
			if (!$id) {
				$this-><?php echo $currentModelName; ?>->create();
			}
			// Data massaging if it is not doable in create or beforeSave
		
			// Try to save
			if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
				$this->message('success');
				$this->xredirect();
				// Force reload
				$this->preserveAppData();
				if (!($this->data = $this-><?php echo $currentModelName; ?>->read($fields, $id))) {
					$this->message('error');
					$this->xredirect(); // forget stored referer and redirect
				}
				$this->restoreAppData();
			} else {
				$this->message('validation');
			}
		}
	
		// First pass or reload
		if(empty($this->data['<?php echo $currentModelName; ?>'])) { // 1st pass
			if ($id) {
				$this->preserveAppData();
				if (!($this->data = $this-><?php echo $currentModelName; ?>->read($fields, $id))) {
					$this->message('error');
					$this->xredirect(); // forget stored referer and redirect
				}
				$this->restoreAppData();
			}
			$this->saveReferer(); // Store actual referer to use in 2nd pass
		}
	
	<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	
		// Render preparation
		// Create lists for options, etc.
	}


	public function <?php echo $admin; ?>delete($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->delete($id)) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(sprintf(__('%s was not deleted.', true), __d('domain', '<?php echo ucfirst(strtolower($singularHumanName)); ?>', true)), 'flash_alert');
			$this->redirect($this->referer());
<?php else: ?>
			$this->flash(sprintf(__('%s was deleted.', true), __d('domain', '<?php echo ucfirst(strtolower($singularHumanName)); ?>', true)), $this->referer());
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash(sprintf(__('%s was deleted.', true), __d('domain', '<?php echo ucfirst(strtolower($singularHumanName)); ?>', true)), 'flash_success');
<?php else: ?>
		$this->flash(sprintf(__('%s was not deleted.', true), __d('domain', '<?php echo ucfirst(strtolower($singularHumanName)); ?>', true)), $this->referer());
<?php endif; ?>
		$this->redirect($this->referer());
	}