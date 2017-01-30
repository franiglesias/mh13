<?php

/**
* A class to manage number to text conversions
*/
class FiNumber
{
/**
 * Main convert method.
 *
 * The method treats the value as a string and splits in three figures chunks ($chunks array), then converts every
 * chunk adding magnitude ($index) as needed.
 * 
 * Finally, removes extra remaining characters if present
 *
 * @param integer $value The value to convert
 * @return string The number as text
 */
	public function convert($value=0)
	{
		if ($value == 0) {
			return __d('finumbers', 'zero', true);
		}
		$chunks = $this->_ungroup($value);
		$text = '';
		$index = count($chunks) - 1;
		foreach ($chunks as $chunk) {
			$part = $this->_convertGroup($chunk, $index);
			if ($index > 0) {
				$part .= __d('finumbers', ', ', true);
			}
			$text .= $part;
			$index--;
		}
		return rtrim($text, ' ,');
	}


/**
 * splits the value string into 3 figures chunks
 *
 * @param string $value 
 * @return array of chunks
 */
	protected function _ungroup($value=0)
	{
		$length = strlen($value);
		$chunks = ceil($length/3);
		$value = str_pad($value, $chunks*3, '0', STR_PAD_LEFT);
		$groups = str_split($value, 3);
		return $groups;
	}
	
/**
 * Convert a 3 figures group
 *
 * @param string $value 
 * @return void
 */
	protected function _convertGroup($value, $idx = 0)
	{
		$hundred = $this->_convertHundred(substr($value,0,1));
		$twoDigit = $this->_convertTwoDigits(substr($value, -2));

		if (!$hundred) {
			$template = __d('finumbers', ':twoDigit', true);
		} elseif (!$twoDigit) {
			$template = __d('finumbers', ':hundred', true);
		} else {
			$template = __d('finumbers', ':hundred and :twoDigit', true);
		}
		$result = String::insert($template, compact('hundred', 'twoDigit'));
		
		$conversions = array(
			1 => __d('finumbers','thousand',true),
			2 => __d('finumbers', 'million', true),
			3 => __d('finumbers', 'billion', true),
			4 => __d('finumbers', 'trillion', true),
			5 => __d('finumbers', 'quadrillion', true),
			6 => __d('finumbers', 'quintrillion', true),
			7 => __d('finumbers', 'sextillion', true),
			8 => __d('finumbers', 'septillion', true),
			9 => __d('finumbers', 'octillion', true),
			10 => __d('finumbers', 'nonillion', true),
			11 => __d('finumbers', 'decillion', true),
		);
		if ($idx > 0) {
			$result .= ' '.$conversions[$idx];
		}
		
		return $result;
	}
	
/**
 * Convert the hundred figure
 *
 * @param integer $value 
 * @return string the converted value
 */
	protected function _convertHundred($value)
	{
		if ($value == 0) {
			return '';
		}
			
		return $this->__hundredConversion($value);
	}

/**
 * Convert the units figure
 *
 * @param integer $value 
 * @return string the converted value
 */

	protected function _convertUnits($value)
	{
		if ($value === 0) {
			return '';
		}
		return $this->__unitConversion($value);
	}
	
/**
 * Convert two digits figures
 *
 * @param integer $value 
 * @return string the converted value
 */

	protected function _convertTwoDigits($value=0)
	{
		$dec = floor($value/10);
		$unit = $value % 10;
				
		if ($dec == 0) {
			return $this->_convertUnits($unit);
		}
		
		if ($dec == 1) {
			return $this->__teenConversion($value);
		}
		
		if ($unit == 0) {
			return $this->__tyConversion($dec); 
		}
		
		return $this->__tyConversion($dec).__d('finumbers', '-', true).$this->_convertUnits($unit);

	}

/**
 * The following private methods provide translatable conversions
 *
 * @param integer $unit The value to convert
 * @return string The text
 */

	private function __hundredConversion($unit)
	{
		$conversions = array(
			1 => __d('finumbers', 'one hundred', true),
			2 => __d('finumbers', 'two hundred', true),
			3 => __d('finumbers', 'three hundred', true),
			4 => __d('finumbers', 'four hundred', true),
			5 => __d('finumbers', 'five hundred', true),
			6 => __d('finumbers', 'six hundred', true),
			7 => __d('finumbers', 'seven hundred', true),
			8 => __d('finumbers', 'eight hundred', true),
			9 => __d('finumbers', 'nine hundred', true),
  		);
		return $conversions[$unit];
	}


	private function __unitConversion($unit)
	{
		$conversions = array(
			1 => __d('finumbers', 'one', true),
			2 => __d('finumbers', 'two', true),
			3 => __d('finumbers', 'three', true),
			4 => __d('finumbers', 'four', true),
			5 => __d('finumbers', 'five', true),
			6 => __d('finumbers', 'six', true),
			7 => __d('finumbers', 'seven', true),
			8 => __d('finumbers', 'eight', true),
			9 => __d('finumbers', 'nine', true),
  		);
		return $conversions[$unit];
	}

	
	private function __teenConversion($teen)
	{
		$conversions = array(
			10 => __d('finumbers', 'ten', true),
			11 => __d('finumbers', 'eleven', true),
			12 => __d('finumbers', 'twelve', true),
			13 => __d('finumbers', 'thirteen', true),
			14 => __d('finumbers', 'fourteen', true),
			15 => __d('finumbers', 'fifteen', true),
			16 => __d('finumbers', 'sixteen', true),
			17 => __d('finumbers', 'seventeen', true),
			18 => __d('finumbers', 'eighteen', true),
			19 => __d('finumbers', 'nineteen', true),
  		);
		return $conversions[$teen];

	}
	
	private function __tyConversion($ty)
	{
		$conversions = array(
			2 => __d('finumbers', 'twenty', true),
			3 => __d('finumbers', 'thirty', true),
			4 => __d('finumbers', 'forty', true),
			5 => __d('finumbers', 'fifty', true),
			6 => __d('finumbers', 'sixty', true),
			7 => __d('finumbers', 'seventy', true),
			8 => __d('finumbers', 'eighty', true),
			9 => __d('finumbers', 'ninety', true),
  		);
		return $conversions[$ty];
	}
	
}


?>