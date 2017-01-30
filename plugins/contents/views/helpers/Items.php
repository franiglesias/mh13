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

class ItemsHelper extends CollectionPresentationModelHelper {
	var $var = 'items';
	var $model = 'Item';
}

?>