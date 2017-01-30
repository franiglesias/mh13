<?php
/**
 * StaticI18n Model
 * 
 * [Short Description]
 *
 * @package default
 * @version $Id$
 **/
class StaticI18n extends ContentsAppModel {
	var $name = 'StaticI18n';
	var $displayField = 'field';
	
	public function getIdForSlug($slug)
	{
		$id = $this->find('first', array(
			'fields' => array('foreign_key'),
			'conditions' => array(
				'model' => 'StaticPage',
				'field' => 'slug',
				'content' => $slug
			)
		));
		if (!$id) {
			return false;
		}
		return $id['StaticI18n']['foreign_key'];
	}
	
}
?>