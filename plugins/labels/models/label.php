<?php
/**
 * Label Model
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class Label extends LabelsAppModel {
	var $name = 'Label';
	
	public function  __construct($id = false, $table = null, $ds = null)
	{
		parent::__construct($id, $table, $ds);
		$this->_findMethods['global'] = true;
		$this->_findMethods['model'] = true;
	}
	
	public function getGlobal()
	{
		$results = $this->find('global');
		return Set::combine($results, '/Label/id', '/Label/title');
	}
	
	public function getModel(AppModel $Model)
	{
		$results = $this->find('model', array('model' => $Model->alias, 'id' => $Model->getID()));
		return Set::combine($results, '/Label/id', '/Label/title');
	}

    public function getByTag($tag)
    {
        $this->setId($tag);

        return $this->field('title');
    }
	
	public function _findGlobal($state, $query, $results = array()) 
	{
		if ($state === 'before') {
			$query['conditions'] = array(
				'owner_model' => null,
				'owner_id' => null
			);
			$query['order'] = array('Label.title' => 'asc');
			return $query;
		}
		return $results;
	}
	
	public function _findModel($state, $query, $results = array())
	{
		if ($state === 'before') {
			$query['conditions'] = array(
				'owner_model' => $query['model'],
				'owner_id' => $query['id']
			);
			$query['order'] = array('Label.title' => 'asc');
			return $query;
		}
		return $results;
	}
	
}
?>
