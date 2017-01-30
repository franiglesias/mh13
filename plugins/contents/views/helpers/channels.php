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

class ChannelsHelper extends CollectionPresentationModelHelper {
	var $var = 'channels';
	var $model = 'Channel';
}