<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Europe/Berlin' for 'CEST/2.0/DST' instead in /Library/WebServer/Documents/mh13/vendors/shells/templates/milhojas/classes/test.ctp on line 22
/* Prizes Test cases generated on: 2013-05-23 09:05:25 : 1369294825*/
App::import('Controller', 'Raffles.Prizes');

class TestPrizesController extends PrizesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PrizesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Prizes = new TestPrizesController();
		$this->Prizes->constructClasses();
	}

	function endTest() {
		unset($this->Prizes);
		ClassRegistry::flush();
	}

}
?>
