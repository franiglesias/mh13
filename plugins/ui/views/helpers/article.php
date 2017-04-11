<?php


/**
* Article Helper
*/
class ArticleHelper extends AppHelper 
{
	var $helpers = array('Html', 'Text', 'Time', 'Ui.Widget');
	
	var $exceptions = array(
		'articles' => array('el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'del'),
		'prepositions' => array('a', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'desde', 'en', 'entre', 'hasta', 'hacia', 'para', 'por', 'según', 'si', 'sin', 'so', 'sobre', 'tras'),
		'conjunctions' => array('y', 'o', 'e', 'u'),
		'other' => array('se','que', 'este', 'esta', 'ese', 'esa', 'esos', 'esas', 'ese', 'esa', 'aquel', 'aquella', 'aquellos', 'aquellas')
	);

/**
 * Special title case convert, taking care of some exceptions
 * 
 * Need to be adapted to i18n
 *
 * @param string $text
 *
 * @return void
 * @author Fran Iglesias
 */
	public function title($text)
	{
		if (empty($text)) {
			return __d('ui', 'Untitled', true);
		}
		$encoding = 'UTF-8';
		mb_regex_encoding($encoding);
		$text = mb_convert_case($text, MB_CASE_TITLE, $encoding);
		foreach ($this->exceptions as $cat => $words) {
			foreach ($words as $exception) {
				$search = '\b'.ucfirst($exception).'\b';
				$text = mb_ereg_replace($search, $exception, $text);
			}
		}
		$text = mb_strtoupper($text{0}, $encoding) . mb_substr($text, 1, mb_strlen($text) - 1, $encoding);
		$text = mb_ereg_replace('\b([IXMLVCixmlvc]+)\b', '\0', $text);
		return $text;
	}


	public function parse($text)
	{
		if (!$text) {
			return false;
		}
		// Look for youtube videos
		$text = preg_replace_callback('/https?:\/\/(?:www)?\.youtube\.com\/watch\?v=([^<&]*)(&\S*)?/', array($this, 'youtube'), $text);
		$text = preg_replace_callback('/https?:\/\/youtu\.be\/([a-zA-Z0-9]*)/', array($this, 'youtube'), $text);
		return $text;
	}

/**
 * Wrapper for WidgetHelper->put() so we can use a callback in parse method
 *
 * @param string $text
 *
 * @return void
 * @author Fran Iglesias
 */
	public function youtube($text)
	{
		return $this->Widget->put('youtube', $text);
	}
 
/**
 * Creates an excerpt of 'size' words given a text.
 * 
 * The method guess the first paragraph to avoid some unaesthetic excerpts.
 *
 * @param string $text
 * @param string $options 'size' in words, 'clean' strip some HTML
 *
 * @return void
 * @author Fran Iglesias
 */
	public function excerpt($text, $options = array('class' => 'excerpt')) {
		$defaults = array(
			'size' => 250, 
			'clean' => true
			);
		$options = array_merge($defaults, $options);
		extract($options);
		if ($clean) {
			$text = $this->clean($text);
		}
		$matches = array();
		if (preg_match_all('/<([^>]+)>(.+)<\/\1>/', $text, $matches, PREG_SET_ORDER)) {
			$text = $matches[0][2];
		}
		$class = false;
		if (!empty($options['class'])) {
			$class = $options['class'];
		}
		$excerpt = $this->Html->para($class, $this->Text->truncate($text, $size, array('html' => true, 'exact' => false)));
		return $excerpt;
	}
	
/**
 * Attempts to clean the entry content
 *
 * @param string $text
 *
 * @return string Cleaned string
 * @author Fran Iglesias
 */
public function clean($text)
{
	$text = Sanitize::stripWhitespace($text);
	// Strip comments
	$text = preg_replace('/<!--(.*)-->/Uis', '', $text);
	// Normalize divs to paragraphs
	$text = preg_replace_callback('/<(p|div)[^>]*>(.*?)<\/\1>/',create_function('$matches', 'return "<p>".trim($matches[2])."</p>".chr(10);'), $text);
	// Strip tagas
	$text = Sanitize::stripTags($text, 'b', 'span', 'div', 'i', 'em', 'strong', 'iframe', 'object', 'br', 'embed', 'img');
	// Stip style attrib
	$text = preg_replace('/style\s?=\s?"[^"]*"/', '', $text);
	// Strip remaing
	$text = trim(preg_replace('/<([^> ]*)>(&nbsp;)?<\/\1>/', '', $text));
	return $text;
}


/**
 * Strips style params in HTML text
 *
 * @param string $text
 *
 * @return void
 * @author Fran Iglesias
 */	
	public function stripStyle($text) {
		$text = preg_replace('/style\s?=\s?"[^"]*"/', '', $text);
		return $text;
	}

/**
 * Creates a time tag
 *
 * @param string $time
 * @param string $format
 *
 * @return void
 * @author Fran Iglesias
 */	
	public function time($time, $format = 'j-m-y H:i')
	{
		$timeString = $this->Time->format($format, $time);
		$code = $this->Html->tag(
			'time',
			$timeString,
			array('datetime' => $this->Time->format(DATE_W3C, $time), 'pubdate' => 'pubdate')
			);
		return $code;
	}
	
/**
 * Creates a complicated yet pretty markup to format a date as a cute calendar
 *
 * @param string $time
 *
 * @return void
 * @author Fran Iglesias
 */
	public function timeAsCalendar($time)
	{
		$timeString = $this->Html->tag('span', $this->Time->format('M-y', $time), array('class' => 'month'));
		$timeString .= $this->Html->tag('span', $this->Time->format('j', $time), array('class' => 'day'));
		$timeString .= $this->Html->tag('span', $this->Time->format('H:i', $time), array('class' => 'time'));
		$timeString = $this->Html->tag('span', $timeString, array('class' => 'calendar'));
		// $timeString = $this->Html->div('calendar', $timeString);
		$code = $this->Html->tag(
			'time',
			$timeString,
			array('datetime' => $this->Time->format(DATE_W3C, $time), 'pubdate' => 'pubdate')
			);
		return $code;
	}

}


?>
