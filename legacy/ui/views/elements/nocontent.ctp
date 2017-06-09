<?php
	$defaults = array(
		'message' => __d('ui','We don\'t have yet any content to put here', true)
	);
	
	extract($defaults, EXTR_SKIP);
?>
<p class="mh-no-content fi-alert"><?php echo $message; ?></p>