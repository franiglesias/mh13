<?php

$defaults = array(
	'search' => false,
);

extract($defaults, EXTR_SKIP);

$data = $this->requestAction(array(
		'plugin' => 'menus',
		'controller' => 'bars',
		'action' => 'bar',
		),
		array('pass' => array($bar))
	);

if (!$data) {
	return;
}
echo $this->Bar->render($data, compact('search'));

?>