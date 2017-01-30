<?php
/**
 * StaticI18n Model
 * 
 * [Short Description]
 *
 * @package default
 * @version $Id$
 **/
class ItemI18n extends ContentsAppModel {
	var $name = 'ItemI18n';
	var $displayField = 'field';
	
	public function getIdForSlug($slug)
	{
		$id = $this->find('first', array(
			'fields' => array('foreign_key'),
			'conditions' => array(
				'model' => 'Item',
				'field' => 'slug',
				'content' => $slug
			)
		));
		if (!$id) {
			return false;
		}
		return $id['ItemI18n']['foreign_key'];
	}
}
?>