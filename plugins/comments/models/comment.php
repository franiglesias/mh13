<?php

class Comment extends CommentsAppModel {
	var $name = 'Comment';
	var $displayField = 'comment';
	
	var $validate = array(
		'comment' => 'notEmpty',
		'name' => 'notEmpty'
	);
	
	var $states = array(
		0 => 'pending',
		1 => 'disapproved',
		2 => 'approved'
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->states = array(
			0 => __d('comments', 'pending', true),
			1 => __d('comments', 'disapproved', true),
			2 => __d('comments', 'approved', true)
		);
	}

/**
 * Set approved field to true for current model or model specified by id
 *
 * @param string $id The id of the comment
 * @return boolean true on success
 */	
	public function approve($id = false)
	{
		if (!$this->id && !$id) {
			return false;
		}
		if ($id) {
			$this->id = $id;
		}
		return $this->saveField('approved', 2, false);
	}


/**
 * Get mode for comments
 *
 * @param string $model 
 * @param string $id 
 * @param string $field 
 * @return void
 */
	public function mode($model, $id, $field = 'allow_comments')
	{
		if (strpos($model, '.') !== false) {
			list($plugin, $class) = explode('.', $model);
		} else {
			$class = $model;
		}
		if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			App::import('Model', $model);
			$Commented = ClassRegistry::init($class);
		} else {
			$Commented = ClassRegistry::init('Commented');
		}
		$Commented->id = $id;
		$mode = $Commented->field($field);
		return $mode;
	}
	
/**
 * Apply some passive defense rules to validate comments
 *
 * @param string $comment 
 * @return void
 */	
	public function antispam($comment, $turing = false) {
		$timeDifference = time() - $comment['Comment']['timestamp'];
		$valid = true;
		if (($timeDifference < 3) || ($timeDifference > HOUR * 2)) {
			$valid = false;
		}
		if ($comment['Comment']['turing'] != $turing['test']) {
			$valid = false;
		}
		return $valid;
	}
	
/**
 * Purgue all moderated (disapproved) comments
 *
 * @return void
 */	
	public function purgue() {
		$conditions = array('Comment.approved' => 1);
		return $this->deleteAll($conditions);
	}	
	
	
}

?>