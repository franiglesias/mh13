<?php
class StaticPage extends ContentsAppModel {
	var $name = 'StaticPage';
	
	var $displayField = 'title';
	
	var $actsAs = array(
		'Translate' => array(
			'title' => 'titleTranslations',
			'content' => 'contentTranslations',
			'slug' => 'slugTranslations'
			),
		'Tree',
		'Ui.Sluggable' => array('update' => true),
		'Access.Ownable' => array('mode' => 'object'),
		'Uploads.Upable' => array(
			'image' => array(
				'move' => 'route',
				'return' => 'link'
				),
			),
		'Uploads.Attachable' => array(
			'MainImage',
			'Image',
			'Download',
			'Multimedia'
			)

	);
	
	var $translateModel = 'Contents.StaticI18n';
	
	var $belongsTo = array(
		'StaticParent' => array(
			'className' => 'Contents.StaticPage',
			'foreignKey' => 'parent_id',
		)
	);
	
	var $hasMany = array(
		'StaticDescendant' => array(
			'className' => 'Contents.StaticPage',
			'foreignKey' => 'parent_id'
		)
	);
	
	var $validate = array(
		'title' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
				)
			),
		'content' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'on' => 'update'
				)
			)

		);
	
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * Returns a tree with the descendants of the current StaticPage
 *
 * @param string $id 
 * @return void
 */
	public function descendants()
	{
		return $this->StaticDescendant->find('threaded', 
			array(
				'fields' => array('id', 'parent_id', 'title', 'slug'),
				'conditions' => array(
					'StaticDescendant.lft >' => $this->data['StaticPage']['lft'], 
					'StaticDescendant.rght <' => $this->data['StaticPage']['rght']
					)
				)
			);
	}
	
	public function findAllParents()
	{

		$db = $this->getDataSource();
		$subQuery = $db->buildStatement(
		    array(
		        'fields'     => array('StaticParent.parent_id'),
		        'table'      => $db->fullTableName($this),
		        'alias'      => 'StaticParent',
		        'limit'      => null,
		        'offset'     => null,
		        'joins'      => array(),
		        'conditions' => null,
		        'order'      => null,
		        'group'      => array('StaticParent.parent_id')
		    ),
		    $this
		);
		$subQuery = ' StaticPage.id IN (' . $subQuery . ') ';
		return $this->find('list', array('conditions' => $subQuery));
	}
	
	public function siblings()
	{
		return $this->find('all', 
			array(
				'fields' => array('id', 'parent_id', 'title', 'slug'),
				'conditions' => array(
					'StaticPage.id !=' => $this->id,
					'StaticPage.parent_id !=' => null,
					'StaticPage.parent_id' => $this->data['StaticPage']['parent_id']
					)
				)
			);
	}
	
	public function parents()
	{
		$result = $this->StaticParent->getpath($this->data['StaticPage']['parent_id'], array('slug', 'title'));
		if (empty($result)) {
			return array();
		}
		return $result;
	}
	
	public function candidateParents()
	{
		return $this->StaticParent->find('list', array('conditions' => array('StaticParent.id !=' => $this->id)));
	}
	
	public function getBySlug($slug)
	{
		$this->setId(ClassRegistry::init('StaticI18n')->getIdForSlug($slug));
	}
	
	public function retrieve($id = null)
	{
		
		$this->Behaviors->enable('Translate');
		$this->setId($id);
		$this->contain(array(
			'MainImage',
			'Image' => array('order' => array('order' => 'ASC', 'name' => 'ASC')), 
			'Download' => array('order' => array('order' => 'ASC', 'name' => 'ASC')), 
			'Multimedia' => array('order' => array('order' => 'ASC', 'name' => 'ASC'))
		));
		$this->data = $this->read(null);
		if (!empty($this->data['MainImage'])) {
			$this->data['MainImage'] = $this->data['MainImage'][0];
		} else {
			$this->data['MainImage'] = array();
		}
		$this->data['Parents'] = $this->parents();
		$this->data['Descendants'] = $this->descendants();
		$this->data['Siblings'] = $this->siblings();
		
	}
	
	public function view($slug)
	{
		try {
			$this->getBySlug($slug);
		} catch (Exception $e) {
			return;
		}
		return $this->retrieve();
	}
	
}
?>