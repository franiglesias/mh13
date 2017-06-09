<?php
/**
 * ItemHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'CollectionPresentationModel');

class ImagesHelper extends CollectionPresentationModelHelper {
	var $var = 'images';
	var $model = 'Image';

	public function gallery($type)
	{
		$G = LayoutFactory::get('list', $this);
		return $G->usingLayout('/ui/images/galleries/'.$type.'/layout')
			->usingTemplate('/ui/images/galleries/'.$type.'/template')
			->withTitle('')
			->withFooter('')
			->render();
	}
	
	public function cut($maxThumbs = 6)
	{
		if ($this->count() <= $maxThumbs) {
			return true;
		}
		$cutEvery = $this->count()/$maxThumbs;
		$slide = $this->pointer();
		return ($slide % $cutEvery == 0);
	}
}

?>