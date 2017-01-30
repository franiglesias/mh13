<?php
extract($ajaxResponse);
$feedback = array(
	'title' => array(
		'required' => __d('contents', 'Please, provide a title for the Item.', true)
		),
	'content' => array(
		'required' => __d('contents', 'Please, provide a minimal content the Item.', true)
		)
	);
$ajaxResponse['time'] = $this->Time->format('H:i:s', time()); 
if ($errors) {
	// $ajaxResponse['message'] = $ajaxResponse['message'];
	unset($ajaxResponse['errors']);
	foreach ($errors as $field => $error) {
		$id = Inflector::Camelize($model.'_'.$field);
		$ajaxResponse['errors'][$id][$error] = $feedback[$field][$error];
	}
}
echo $this->Js->object($ajaxResponse);
?>
