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
App::import('Helper', 'SinglePresentationModel');

class LicenseHelper extends SinglePresentationModelHelper 
{
	var $helpers = array('Html', 'Form', 'Ui.FForm', 'Ui.Table');
	var $model = 'License';
	var $source = 'license';
}