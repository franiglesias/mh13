<?php

class SlugRoute extends CakeRoute {
 
    function parse($url) {
        $params = parent::parse($url);
        if (empty($params)) {
            return false;
        }

		if (empty($params['slug'])) {
			return $params;
		}
		
		$slugs = Cache::read('item_slugs');
		
		if (!empty($slugs) && in_array($params['slug'], $slugs)) {
			return $params;
		}
		// If slug matches a channel transform request to retrieve channel index page
		if ($this->_isChannel($params['slug'])) {
			unset($params['controller']);
			$params['controller'] = 'channels';
			return $params;
		}
		
		App::import('Model', 'Contents.Item');
		$Item = ClassRegistry::init('Item');
		$count = $Item->find('first', array('conditions' => array('I18n__slug.content' => $params['slug'])));
		if ($count) {
			$slugs[] = $params['slug'];
			Cache::write('item_slugs', $slugs);
			return $params;
		}
        return false;
    }

/**
 * Checks if a given slug points to a channel
 *
 * @param string $slug
 *
 * @return void
 */
	public function _isChannel($slug)
    {
        App::import('Model', 'Contents.Channel');
		$Channel = ClassRegistry::init('Channel');
		$count = $Channel->find('first', array('conditions' => array('I18n__slug.content' => $slug)));
		unset($Channel);
		if ($count) {
			return true;
		}
		return false;
    }

    public function match($url)
    {
        $keys = array(
            'plugin' => 'contents',
            'controller' => 'items',
            'action' => 'view',
        );
        if (array_intersect_assoc($keys, $url) == $keys) {
            return '/'.$url[0];
        }

        return false;
    }

}

?>
