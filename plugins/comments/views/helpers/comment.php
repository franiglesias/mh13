<?php
/**
 * CommentsHelper
 * 
 * [Short Description]
 *
 * @package comments.milhojas
 * @version $Id$
 **/

if (!defined('COMMENTS_NO')) {
	define('COMMENTS_NO', 0);
}

if (!defined('COMMENTS_CLOSED')) {
	define('COMMENTS_CLOSED', 1);
}

if (!defined('COMMENTS_MODERATED')) {
	define('COMMENTS_MODERATED', 2);
}

if (!defined('COMMENTS_FREE')) {
	define('COMMENTS_FREE', 3);
}


class CommentHelper extends AppHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Js', 'Form', 'Session');

	var $test = 0;

	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @access public
	 */
	function beforeRender() {
		// Get logged user name and handle it to the view
		if ($user = $this->Session->read('Auth.User')) {
			$keys = array('id' => true, 'realname' => true);
			$user = array_intersect_key($user, $keys);
			ClassRegistry::getObject('view')->viewVars['user'] = $user;
		}
		ClassRegistry::getObject('view')->viewVars['test'] = rand(10,20);
	}

	public function turing($test) {
		$test = rand(10,999);
		App::import('Lib', 'FiNumber');
		$N = ClassRegistry::init('FiNumber');
		$clue = $N->convert($test);
		unset($N);
		$this->test = array('clue' => $clue, 'test' => $test);
		$_SESSION['Turing'] = $this->test;
		return $this->Form->input('turing', array('label' => sprintf(__d('comments', 'Write with numbers "%s"', true), $clue)));
	}

    /**
     * Use to create a block of comments in a view. The helper manages all details given the $mode parameter
     *
     * @param string $model Model Class of the Object being commented
     * @param string $id    ID of the Object being commented
     * @param string $mode  Mode of comments COMMENTS_NO, COMMENTS_CLOSED, COMMENTS_MODERATED, COMMENTS_FREE
     *
     * @return HTML block
     */
    public function render($model, $id, $mode)
    {
        if (!$mode) {
            return false;
        }
        $code = array();
        $code[] = $this->Html->tag('div', $this->display($model, $id, $mode));
        if ($mode > COMMENTS_CLOSED) {
            $code[] = $this->Html->tag('div', $this->form($model, $id, '', $mode), array('id' => 'comments-form'));
        }

        return implode(chr(10), $code);
    }
	
	public function display($model, $fk, $mode) {
        $View = ClassRegistry::getObject('view');
		$commentsList = $this->RequestAction(
			array(
				'plugin' => 'comments',
				'controller' => 'comments',
				'action' => 'display'
				),
			array(
				'pass' => array($model, $fk),
				)
			);
		$ret = $View->element('display', array(
			'plugin' => 'comments', 
			'model' => $model, 
			'fk' =>  $fk, 
			'mode' => $mode, 
			'commentsList' => $commentsList
		));
		$ret = $this->Html->tag('div', $ret, array('id' => 'comments-display'));
		return $ret;		
	}

    public function form($objectModel, $objectID, $redirect = '', $mode = COMMENTS_MODERATED)
    {
        $View = ClassRegistry::getObject('view');
        $ret = $View->element(
            'form',
            array(
                'plugin' => 'comments',
                'model' => $objectModel,
                'fk' => $objectID,
                'redirect' => serialize($redirect),
                'mode' => $mode // 2: moderated, 3: free
            )
        );

        return $ret;
	}

/**
 * After render callback.  afterRender is called after the view file is rendered
 * but before the layout has been rendered.
 * 
 * Load base CSS for comments
 *
 * @access public
 */
	function afterRender() {
		if (!defined('MH_DO_NOT_LOAD_CUSTOM_CSS')) {
			echo $this->Html->css('/comments/css/comments', null, array('inline' => false));
		}
	}

}
