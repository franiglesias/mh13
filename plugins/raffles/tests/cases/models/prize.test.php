<?php

App::import('Model', 'Raffles.Prize');

class PrizeTestCase extends CakeTestCase {
	
	var $fixtures = array(
		'plugin.raffles.prize'
	);
	
	function startTest() {
		$this->Prize =& ClassRegistry::init('Prize');
	}

	function endTest() {
		unset($this->Prize);
		ClassRegistry::flush();
	}

	public function testGetSponsors()
	{
		$expected = array(
			'Lorem ipsum',
			'Dolor sit'
		);
		$result = $this->Prize->getSponsors();
		$this->assertEqual($expected, $result);
	}
}
?>