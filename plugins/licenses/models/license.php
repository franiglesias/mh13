<?php
class License extends LicensesAppModel {
	var $name = 'License';
	var $displayField = 'license';
	
	var $validate = array(
		'license' => 'notEmpty'
	);
}
?>