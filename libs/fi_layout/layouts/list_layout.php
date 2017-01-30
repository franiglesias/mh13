<?php

App::import('Lib', 'fi_layout/FiLayout');

/**
* 
*/
class ListLayout extends AbstractLayout
{
	public function order()
	{
		return range(0, $this->CollectionPresentationModel->count()-1);
	}
	
}

?>