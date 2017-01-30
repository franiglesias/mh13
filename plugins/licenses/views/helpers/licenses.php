<?php
/**
 * LicenseHelper
 * 
 * [Short Description]
 *
 * @package licenses.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'CollectionPresentationModel');

class LicensesHelper extends CollectionPresentationModelHelper {
	
	var $helpers = array('Html', 'Form', 'Ui.FForm', 'Ui.Table');
	var $model = 'License';
	var $source = 'licenses';
	
	
}