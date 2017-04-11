<?php
/**
 *  fi_text
 *
 *  Created by  on 2013-07-12.
 **/

/**
* 
*/
class FiText
{
/**
 * Uses Google Translate to translate texts between two languages.
 *
 * @param string $text
 * @param string $from The two letters language code
 * @param string $to   two letter lang code
 *
 * @return string
 * @author Frankie
 */
	var $storedUrl = array();
	var $removeAttributes = array(
		'style',
		'class',
		'id'
	);

/**
 * Uses a hack to translate texts using google translator
 *
 * @param string $text The text to translate
 * @param string $from The source language
 * @param string $to   The target language
 *
 * @return string The translated text
 */
	function translate($text, $from, $to)
	{
		if (empty($text)) {
			return '';
		}
		$text = urlencode($text);
		$url = "http://translate.google.es/translate_a/t?client=t&text={$text}&hl=es&sl={$from}&tl={$to}&ie=UTF-8&oe=UTF-8&multires=1&otf=2&ssel=0&tsel=3";
		$content = file_get_contents($url);
		if (!$content) {
			return false;
		}
	    //Procesamos la respuesta
		preg_match_all('/\[+"(.*?)",".*?"\]/', $content, $procesa);
		$translated = '';
		foreach($procesa[1] as $procesado) {
			if (!preg_match("/,\[+.*?\]/", $procesado)) {
				$translated .= $procesado . " ";
			}
		}
		$translated = str_replace('\\n', chr(10), $translated);
		$translated = preg_replace('/\n +/', chr(10), $translated);
		return trim($translated);
	}

/**
 * Performs several text cleaning routines
 *
 * @param string $text HTML text
 *
 * @return string the clean text
 */
	public function clean($text) {
		$clean = $text;
		$clean = $this->removeAttributes($clean);
		$clean = $this->cleanPunctuation($clean);
		$clean = $this->cleanEmptyTags($clean);
		return $clean;
	}
	
/**
 * Remove attributes specified in $this->removeAttributes array
 *
 * @param string $html
 *
 * @return string clean text
 */
    public function removeAttributes($html)
    {
        foreach ($this->removeAttributes as $attr) {
            $html = preg_replace('/'.$attr.'="[^"]*"/', '', $html);
        }

        return $html;
	}

/**
 * Cleans punctuation:
 *	fixes space runs
 *  fixes spaces before and after
 *
 * protects html entities and url
 *
 * @param string $text
 *
 * @return string clean text
 */	
	public function cleanPunctuation($text) {
		// Detect and protect entities
		$text = $this->_protectEntities($text);
		// Detect and protect url
		$text = $this->protectUrl($text);
		// Punctuation followed by a whitespace
		$text = str_replace('...', '…', $text);
		$clean = preg_replace('/\s?([.:,;?!\]\)])\s?/', '$1 ', $text);
		$clean = mb_ereg_replace('/\s?([\(\¿\¡\[])\s?/', ' \\1', $clean);
		// Clean running spaces
		$clean = preg_replace('/\s{2,}/', ' ', $clean);
		// Recover urls
		$clean = $this->recoverUrl($clean);
		// Recover entities
		$clean = $this->_recoverEntities($clean);
		return trim($clean);
	}

    /**
     * Methods to protect entities
     *
     * @param string $text
     *
     * @return string
     */
    protected function _protectEntities($text)
    {
        return preg_replace('/&([^;]+);/', '##$1##', $text);
    }

    /**
     * Methods to protect URLs
     *
     * @param string $text
     *
     * @return string
     */
    function protectUrl($text)
    {
        $this->storedUrl = array();
        $pattern = "/(((ftp|https?):\/\/)(www\.)?|www\.)([\da-z-_\.]+)([a-z\.]{2,7})(\:\d*)?([\/\w\.\-\=\%_\?\&]*)*(\/?)/";
        $urls = array();
        preg_match_all($pattern, $text, $urls);
        $this->storedUrl = $urls[0];
        foreach ($this->storedUrl as $key => $url) {
            if (substr($url, -1) == '.') {
                $this->storedUrl[$key] = $url = substr($url, 0, -1);
            }
            $text = str_replace($url, '@@'.$key.'@@', $text);
        }

        return $text;
    }

    public function recoverUrl($text)
    {
        if (!$this->storedUrl) {
            return $text;
        }
        foreach ($this->storedUrl as $key => $url) {
            $search = '@@'.$key.'@@';
            $text = str_replace($search, $url, $text);
        }
        $this->storedUrl = array();

        return $text;
    }

    protected function _recoverEntities($text)
    {
        return preg_replace('/##([^#]+)##/', '&$1;', $text);
    }

    /**
     * Removes tags with no content
     *
     * @param string $text
     *
     * @return string clean text
     */
    public function cleanEmptyTags($text)
    {
        $text = $this->cleanSpacesBetweenTags($text);
        $clean = preg_replace('/<(\w+)[^>]*><\/\1>/', '', $text);

        return $clean;
    }

    /**
     * Clean spaces (and other spacing characters) before, after and inside tags
     * Takes no breaking space into consideration
     *
     * @param string $text
     *
     * @return string clean text
     */
    public function cleanSpacesBetweenTags($text)
    {
        $text = str_replace('&nbsp;', ' ', $text);
        $clean = preg_replace('/\s*(<|>)\s*/', '$1', $text);
        // Some exceptions
        $clean = preg_replace('/<a[^>]*>[^<]*<\/a>/', ' $0 ', $clean);
        $clean = preg_replace('/<strong[^>]*>[^<]*<\/strong>/', ' $0 ', $clean);
        $clean = preg_replace('/<em[^>]*>[^<]*<\/em>/', ' $0 ', $clean);
        $clean = preg_replace('/<span[^>]*>[^<]*<\/span>/', ' $0 ', $clean);

        return trim($clean);
    }

    /**
     * Performs several text cleaning routines in a plain text
     *
     * @param string $text
     *
     * @return string The clean text
     */
    public function cleanPlain($text)
    {
        $clean = $text;
        $clean = $this->cleanPunctuation($clean);

        return $clean;
    }

/**
 * Basic capitalization fixing (start of text, after periods...)
 *
 * @param string $text
 *
 * @return string fixed text
 */
	public function fixCapitalization($text) {
		$html = false;
		if (is_array($text)) {
			$html = true;
			$text = $text[1];
		}
        $fixed = preg_replace_callback(
            '/^(.)|\.(\n*)\s*(.)/',
            array($this, '__capHelper'),
            $text);

		if ($html) {
			$fixed = '<p>'.$fixed.'</p>';
		}
		return $fixed;
	}

    public function fixCapitalizationHtml($text)
	{
		$fixed = preg_replace_callback('/<p>([^<]+)<\/p>/',
			array($this, 'fixCapitalization'),
			$text);
		return $fixed;
	}

    /**
     * Clean and converts quotes into smart quotes
     *
     * @param string $text
     *
     * @return string clean text
     * @author Fran Iglesias
     */
    public function cleanQuotes($text, $smart = true)
    {
        if ($smart) {
            $clean = preg_replace('/\"\s*([^"]*?)\s*\"/', '&ldquo;$1&rdquo;', $text);
        } else {
            $clean = preg_replace('/\"\s*([^"]*?)\s*\"/', '"$1"', $text);
        }

        return $clean;
    }
	
/**
 * callback for fixCapitalizacion
 *
 * @param string $matches
 *
 * @return string the replacement
 */
	private function __capHelper($matches) {
		if (!empty($matches[1])) {
			$replace = $matches[1];
		} elseif (!empty($matches[3])) {
			// Manages carriage returns
			if (!empty($matches[2])) {
				$replace = '.'.chr(10).$matches[3];
			} else {
				$replace = '. '.$matches[3];
			}
		}
		return strtoupper($replace);
	}
	
}


?>
