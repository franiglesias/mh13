<?php

App::import('Lib', 'fi_value/abstracts/FiFormatter');

class ExcerptFormatter extends FiFormatter
{
	
	public function __construct(FiValue $Value, $words)
	{
		parent::__construct($Value, $words);
	}
	
	public function format()
	{
		$formatted = $this->useOnlyFirstParagraph();
		if ($this->textIsShorterThanLimit($formatted)) {
			return $formatted;
		}
		return $this->extractFirstWords($formatted).'…';
	}

	/**
	 * Extract first paragraph to work on it
	 *
	 * @param string $text 
	 * @return string the paragraph
	 * @author Fran Iglesias
	 */
	private function useOnlyFirstParagraph()
	{
		$text = str_replace(chr(13), chr(10), $this->prepareHtml($this->_Value->get()));
		if ($firstNewLine = strpos($text, chr(10))) {
			return substr($text, 0, $firstNewLine);
		}
		return $text;
	}
	
	private function prepareHtml($text)
	{
		return strip_tags(str_replace('</p>', '</p>'.chr(10), $text));
	}
	
	private function textIsShorterThanLimit($text)
	{
		return str_word_count($text) < $this->_format;
	}
	
	private function extractFirstWords($text)
	{
		return trim(preg_replace("/^\W*((\w[\w'-]*\b\W*){1,$this->_format}).*/ms", '\\1', $text));
	}
}

?>
