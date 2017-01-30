<?php
/**
 * MenuHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'CollectionPresentationModel');

class MenusHelper extends CollectionPresentationModelHelper {

	var $model = 'Menu';
	var $var = 'menus';
	
}