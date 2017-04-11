<?php
/**
 * Sluggable Model Behavior
 * 
 * [Short Description]
 *
 * @package default
 * @version $Id$
 * @copyright Fran Iglesias
 **/
class SluggableBehavior extends ModelBehavior {

/**
 * Contains configuration settings for use with individual model objects.
 * Individual model settings should be stored as an associative array, 
 * keyed off of the model name.
 *
 * @var array
 * @access public
 * @see Model::$alias
 */
	var $settings = array();
	
	var $defaultSettings = array(
		'fields' => 'title', // A field or array of fields to convert to slug
		'slug' => 'slug', // The field in which the slug is stored
		'lenght' => 100, // Limit the lenght of the slug string, 0 means no limit
		'update' => false, // Change slug every time the model is updated
		'replacement' => '_', // Replacement for non word characters
		'lowercase' => true, // Convert slug string to lowercase, to avoid problems with some servers,
		'translate' => false, // The model uses translate behavior
		'translatedFields' => false
		);

/**
 * Allows the mapping of preg-compatible regular expressions to public or
 * private methods in this class, where the array key is a /-delimited regular
 * expression, and the value is a class method.  Similar to the functionality of
 * the findBy* / findAllBy* magic methods.
 *
 * @var array
 * @access public
 */
	var $mapMethods = array();


/**
 * Initiate Sluggable Behavior
 *
 * @param object $model
 * @param array $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		// Merge settings
		$this->settings[$model->alias] = Set::merge($this->defaultSettings, $config);
		extract($this->settings[$model->alias]);
		if (!is_array($fields)) {
			$this->settings[$model->alias]['fields'] = $fields = array($fields);
		}
		// Check if all implied fields are present in the model, if not trigger errors
		// Check if model uses Translate Behavior and get the translated fields
		if ($translatedFields = $model->translatedFields()) {
			// $translate = true;
			// $s = $model->Behaviors->Translate->settings[$model->alias];
			// if (is_numeric(key($s))) {
			// 	$translatedFields = $s;
			// } else {
			// 	$translatedFields = array_keys($s);
			// }
			$this->settings[$model->alias]['translatedFields'] = $translatedFields;
			$this->settings[$model->alias]['translate'] = $translate = true;
		}
		// Check if needed field are present in the model or if they are translated fields
		$testFields = $fields;
		$testFields[] = $slug;
		$errors = false;
		
		foreach ($testFields as $field) {
			if (!$translate) {
				if (!$model->hasField($field)) {
					$errors[] = $field;
				}
			} else {
				if (!in_array($field, $translatedFields) && !$model->hasField($field)) {
					$errors[] = $field;
				}
			}
		}
		
		if ($errors) {
			trigger_error("Needed fields ".implode(', ', $errors)." don't exist.", E_USER_WARNING);
		}
	}

/**
 * Before save callback
 *
 * @param object $model Model using this behavior
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeSave(&$model) { 
		extract($this->settings[$model->alias]);

		// Get existing slug if needed
		if ($model->id && !isset($model->data[$model->alias][$slug])) {
			$prev = $model->find('first', array('fields' => array($slug), 'conditions' => array($model->alias.'.id' => $model->id)));
			$previousSlug = $prev[$model->alias][$slug];
			$model->data[$model->alias][$slug] = $previousSlug;
		}

		// Force update if slug field is empty
		if (empty($model->data[$model->alias][$slug])) {
			$update = true;
		}
		
		// Don't do anything if update is not needed (new record o $update is false)
		if ($model->id && !$update) {
			return true;
		}
		
		// Prepare texts
		foreach($fields as $field) {
			if (!isset($model->data[$model->alias][$field])) {
				return true;
			}
			$texts[] = $model->data[$model->alias][$field];
		}
		$text = implode($replacement, $texts);
		
		if (!$text) {
			return true;
		}
		
		if ($lowercase) {
			$text = $this->strtolower($text);
		}
		$theSlug = $this->slug($text, $replacement, $lenght);

		// Prevents conflicts when title has numeric indexes
		$findSlug = preg_replace('/\d+$/', '', $theSlug);
		
		// Check for uniqueness. Inspired by the original Sluggable. Find all potential conflicts in a unique query
		if ($translate && in_array($slug, $translatedFields)) {
			$conditions = array('I18n__'.$slug.'.content' . ' LIKE ' => $findSlug .'%');
		} else {
			$conditions = array($slug . ' LIKE ' => $findSlug .'%');
		}
		if ($model->id) {
			$conditions[$model->alias.'.id !='] = $model->id;
		}
		$slugs = $model->find ('all', array(
			'fields' => array($slug),
			'conditions' => $conditions
			)
		);
		
		$slugs = Set::extract('/'.$model->alias.'/'.$slug, $slugs);
		// If conflicts try to resolve adding a numerical index
		if ($slugs) {
			$done = false;
			while (!$done) {
				if (!in_array($theSlug, $slugs)) {
					$done = true;
					continue;
				}
				$number = array();
				preg_match('/\d+$/', $theSlug, $number);
				$number = array_shift($number);
				if (!$number) {
					$theSlug .= $replacement . '1';
				} else {
					$replace = $number + 1;
					$theSlug = str_replace($number, $replace, $theSlug);
				}
			}
		}
		// If the slug field is a translated one, then store the slug in the beforeSave data of the Translate Behavior
		if ($translate && in_array($slug, $translatedFields)) {
			$model->Behaviors->Translate->runtime[$model->alias]['beforeSave'][$slug] = $theSlug;
		} else {
			$model->data[$model->alias][$slug] = $theSlug;	
		}
			
		return true;
	}

/**
 * Taken from php.net doumentation for strtolower. Alternative to solve a problem
 * with accented capitals in Spanish
 *
 * @param string $string The text to convert
 *
 * @return string The lowered string
 */
	protected function strtolower($string) {
        $convert_to = array(
            "a",
            "b",
            "c",
            "d",
            "e",
            "f",
            "g",
            "h",
            "i",
            "j",
            "k",
            "l",
            "m",
            "n",
            "o",
            "p",
            "q",
            "r",
            "s",
            "t",
            "u",
            "v",
            "w",
            "x",
            "y",
            "z",
            "à",
            "á",
            "â",
            "ã",
            "ä",
            "å",
            "æ",
            "ç",
            "è",
            "é",
            "ê",
            "ë",
            "ì",
            "í",
            "î",
            "ï",
            "ð",
            "ñ",
            "ò",
            "ó",
            "ô",
            "õ",
            "ö",
            "ø",
            "ù",
            "ú",
            "û",
            "ü",
            "ý",
            "а",
            "б",
            "в",
            "г",
            "д",
            "е",
            "ё",
            "ж",
            "з",
            "и",
            "й",
            "к",
            "л",
            "м",
            "н",
            "о",
            "п",
            "р",
            "с",
            "т",
            "у",
            "ф",
            "х",
            "ц",
            "ч",
            "ш",
            "щ",
            "ъ",
            "ы",
            "ь",
            "э",
            "ю",
            "я",
        );
        $convert_from = array(
            "A",
            "B",
            "C",
            "D",
            "E",
            "F",
            "G",
            "H",
            "I",
            "J",
            "K",
            "L",
            "M",
            "N",
            "O",
            "P",
            "Q",
            "R",
            "S",
            "T",
            "U",
            "V",
            "W",
            "X",
            "Y",
            "Z",
            "À",
            "Á",
            "Â",
            "Ã",
            "Ä",
            "Å",
            "Æ",
            "Ç",
            "È",
            "É",
            "Ê",
            "Ë",
            "Ì",
            "Í",
            "Î",
            "Ï",
            "Ð",
            "Ñ",
            "Ò",
            "Ó",
            "Ô",
            "Õ",
            "Ö",
            "Ø",
            "Ù",
            "Ú",
            "Û",
            "Ü",
            "Ý",
            "А",
            "Б",
            "В",
            "Г",
            "Д",
            "Е",
            "Ё",
            "Ж",
            "З",
            "И",
            "Й",
            "К",
            "Л",
            "М",
            "Н",
            "О",
            "П",
            "Р",
            "С",
            "Т",
            "У",
            "Ф",
            "Х",
            "Ц",
            "Ч",
            "Ш",
            "Щ",
            "Ъ",
            "Ъ",
            "Ь",
            "Э",
            "Ю",
            "Я",
        );

        return str_replace($convert_from, $convert_to, $string);
	}

    /**
     * Wrapper to call Inflector::slug to avoid some mistakes in Spanish and make some changes in the result,
     * like truncate the slug to the desired length if any defined
     *
     * @param string $text        The text to slug
     * @param string $replacement defaults to _. The replacement character for chars
     *                            not found by the Inflector::slug method
     * @param string $lenght      Truncate to this length, id 0 leave as is
     *
     * @return string The slugged and truncated text
     */
    protected function slug($text, $replacement = '_', $lenght = 0)
    {
        Inflector::rules('transliteration', array('/gü/' => 'gu', '/GÜ/' => 'GU'));
        $slug = Inflector::slug($text, $replacement);
        if (!$lenght) {
            return $slug;
        }

        return substr($slug, 0, $lenght);
    }

} // End of SluggableBehavior

?>
