<?php

/**
 * Genera una clave legible que se puede memorizar por humanos con mayor facilidad
 * sin que por eso se pierda demasiada seguridad
 * @param $strenght: 'l' (baja), 'm' (media), 'h' (alta). Por defecto es 'm'. Indica
 * la solidez teórica de la contraseña generada (más larga y con palabras más difíciles
 * de localizar en un diccionario0)
 *
 * @return string La clave generada
 **/

define ('CL_ALTA', 'h');
define ('CL_MEDIA', 'm');
define ('CL_BAJA', 'l');

/**
* Readable Password Generator for Spanish
*/
class PasswordGenerator
{
	const HIGH = 0;
	const MEDIUM = 2;
	const LOW = 4;
	
	function readable($strenght = PasswordGenerator::MEDIUM) {
		// Preparamos los parámetros de la generación a partir de la indicación de fortaleza
		$strenght = strtolower($strenght);
		if ($strenght == self::HIGH) {
			$factor = 0;
			$syllables = 5;
		} elseif ($strenght == self::LOW ) {
			$factor = 4;
			$syllables = 3;
		} else {
			$factor = 2;
			$syllables = 4;
		}
		// Fuentes de los caracteres, si quieres modificar la probabilidad de cada uno, añade los que desees
		$consonants = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'ñ', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z', ' ');
		$grupos = array('b', 'bl', 'br', 'c', 'ch', 'cl', 'cr', 'd', 'f', 'fl', 'fr', 'g', 'h', 'j', 'k', 'l', 'll', 'm', 'n', 'ñ', 'p', 'pr', 'pl', 'q', 'r', 's', 't', 'tr', 'v', 'w', 'x', 'y', 'z', ' ');
		$vowels = array('a', 'e', 'i', 'o', 'u');
		$diptongos = array('a', 'e', 'i', 'o', 'u', 'ai', 'au', 'ei', 'eu', 'ia', 'ie', 'io', 'oi', 'ou', 'ua', 'ue', 'uo');
		$finales = array(' ', 'n', 'l', 's', 'r', 'd');
		// Generación de la contraseña. Cada sílaba se construye con una consontante o grupo inicial, una vocal y una consonante final. Se introduce un factor de aleatoriedad regulado por la fortaleza para generar sílabas más o menos simples. 
		$clave = '';
		for ($i=0; $i < $syllables; $i++) { 
			$consonant = rand(0,$factor) ? $consonants[rand(0, count($consonants)-1)] :  $grupos[rand(0, count($grupos)-1)] ;
			$vowel = rand(0, 2*$factor) ? $vowels[rand(0, count($vowels)-1)] : $diptongos[rand(0, count($diptongos)-1)];
			$final = rand(0, 4*$factor) ? '' : $finales[rand(0, count($finales)-1)];
			$clave .= trim($consonant . $vowel . $final);
		}
		return $clave;
	}
}


?>
