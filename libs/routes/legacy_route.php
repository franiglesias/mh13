<?php

class LegacyRoute extends CakeRoute {
 
    function parse($url) {
        $params = parent::parse($url);
        if (empty($params)) {
            return false;
        }

		if (empty($params['id'])) {
			return $params;
		}
				
		App::import('Model', 'Contents.Legacy');
		$Legacy = ClassRegistry::init('Legacy');
		
		$data = $Legacy->find('first', array('conditions' => array('id' => $params['id'])));
		if ($data) {
			$params['id'] = $data['Legacy']['slug'];
			return $params;
		}
		
		return $params;
    }


}
 
?>