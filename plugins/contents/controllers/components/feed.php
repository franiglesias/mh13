<?php
/**
 * FeedComponent
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class FeedComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
	}

    public function getFeed($Item, $params)
    {
        if ($this->fullFeedRequested($params)) {
            return $this->full($Item, $params);
        } elseif ($this->channelFeedRequested($params)) {
            return $this->channel($Item, $params);
        } elseif ($this->siteFeedRequested($params)) {
            return $this->site($Item, $params);
        }
	}

    private function fullFeedRequested($params)
    {
        return empty($params['named']['channel']) && empty($params['named']['site']);
    }

    public function full($Item, $params)
    {
        $dto = [
            'channel' => [
                'title' => Configure::read('Site.title'),
                'description' => Configure::read('Site.description'),
                'link' => Router::url('/', true),
            ],
            'items' => $Item->findFeed(['excludePrivate' => true]),
        ];

        return $dto;
	}

    private function channelFeedRequested($params)
    {
        return !empty($params['named']['channel']);
    }

    public function channel($Item, $params)
	{
        $theChannel = $Item->Channel->find(
            'first',
            array(
                'conditions' => array('I18n__slug.content' => $controller->params['named']['channel']),
		));
        $dto = [
            'channel' => [
                'title' => $theChannel['Channel']['title'],
                'description' => $theChannel['Channel']['description'],
                'link' => Router::url(
                    array(
                        'plugin' => 'contents',
                        'controller' => 'channels',
                        'action' => 'view',
                        $theChannel['Channel']['slug'],
                    ),
                    true
                ),
            ],
            'items' => $Item->findFeed(['channelList' => $theChannel['Channel']['id']]),
        ];

        return $dto;
	}

    private function siteFeedRequested($params)
    {
        return !empty($params['named']['site']);
    }

    public function site($Item, $params)
	{
		App::import('Model', 'Contents.Site');
		$site = ClassRegistry::init('Site')->find('first', array(
			'conditions' => array('Site.key' => $controller->params['named']['site'])
		));
        $dto = [
            'channel' => [
                'title' => $site['Site']['title'],
                'description' => $site['Site']['description'],
                'link' => Router::url(
                    array('plugin' => 'contents', 'controller' => 'sites', 'action' => 'view', $site['Site']['key'])
                ),

            ],
            'items' => $Item->findFeed(['siteName' => $site['Site']['key']]),
        ];

        return $dto;
	}
}
?>
