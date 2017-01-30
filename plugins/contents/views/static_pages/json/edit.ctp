<?php
extract($ajaxResponse);
$feedback = array(
	'title' => array(
		'required' => __d('contents', 'Please, provide a title for the Static Page', true)
		),
	'content' => array(
		'required' => __d('contents', 'Please, provide a minimal content the Static Page.', true)
		)
	
	);
$ajaxResponse['time'] = $this->Time->format('H:i:s', time()); 
if ($errors) {
	unset($ajaxResponse['errors']);
	foreach ($errors as $field => $error) {
		$id = Inflector::Camelize($model.'_'.$field);
		$ajaxResponse['errors'][$id][$error] = $feedback[$field][$error];
	}
}
echo $this->Js->object($ajaxResponse);
?>