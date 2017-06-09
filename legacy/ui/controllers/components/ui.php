<?php
/**
 * UiComponent
 * 
 * [Short Description]
 *
 * @package ui.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class UiComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array();

	/**
	 * A path to find themes
	 *
	 * @var string
	 */
	var $themesPath;
	/**
	 * A path to find layouts
	 *
	 * @var string
	 */
	var $layoutsPath;

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
		$this->themesPath = VIEWS . 'themed' . DS;
		$this->layoutsPath = VIEWS;
	}

	/**
	 * Called after the Controller::beforeFilter() and before the controller action
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function startup(&$controller) {
	}

	/**
	 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
	 * Controller::render()
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function beforeRender(&$controller) {
	}

	/**
	 * Called after Controller::render() and before the output is printed to the browser.
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function shutdown(&$controller) {
	}

	/**
	 * Called before Controller::redirect()
	 *
	 * @param object  A reference to the controller
	 * @param mixed  A string or array containing the redirect location
	 * @access public
	 */
	function beforeRedirect(&$controller, $url, $status = null, $exit = true) {
	}
	
	
	public function setThemesPath($path = false)
	{
		if (!$path) {
			$this->themesPath = VIEWS . 'themed' . DS;
			return;
		}
		$this->themesPath = $path;
	}
	
	/**
	 * Get a list of themes looking into the views/themed folder
	 *
	 * @return array
	 */
	public function themes() {
		$folder = new Folder($this->themesPath);
		$themes = $folder->read(true, true);
		unset($folder);
		$themes = array_shift($themes);
		$themes = array_combine($themes, $themes);
		return $themes;
	}
	
	
	public function setLayoutsPath($path = false)
	{
		if (!$path) {
			$this->layoutsPath = VIEWS;
			return;
		}
		$this->layoutsPath = $path;
	}

    /**
     * Returns an array with the name of layouts suitable for a given key.
     * If a theme name is provided, it will look for layouts in the themed folder and in the views root
     * If there are two layouts with the same name, it uses the themed one
     * Name conventions for layouts: name.key.ctp key: can be channel|site|item
     *
     *
     * @param string $theme Theme name (false, use configuration Site.theme). You should provide the theme name if
     *                      available in the channel data
     * @param string $key   channel/site/item (defaults to channel)
     *
     * @return array
     */
    public function layouts($theme = false, $key = 'channel')
    {
        $layouts = $this->layoutsList(false, $key);
        if ($theme) {
            $themed = $this->layoutsList($theme, $key);
            if (!empty($themed)) {
                $layouts = array_merge($layouts, $themed);
            }
        }

        return $layouts;
    }
	
/**
 * Retrieve a list of layouts. If a theme is given, it looks for them into the themed folder
 *
 * @param string $theme a theme name or false
 * @param string $key   channel|site|item
 *
 * @return array or false
 */
	public function layoutsList($theme, $key)
	{
		$pattern = '(.*\.)?'.$key.'\.ctp';
		$path = $this->layoutsPath;

        if ($theme) {
			$path .= 'themed'.DS .$theme . DS;
		}
		$path .= 'layouts';
		$folder = new Folder($path);
		$layouts = $folder->find($pattern);
		unset($folder);
		if (empty($layouts)) {
			return false;
		}
		foreach ($layouts as &$layout) {
			$name = str_replace('.ctp', '', $layout);
			if (empty($theme)) {
				$list[$name] = 'Generic::'.$name;
			} else {
				$list[$name] = $theme.'::'.$name;
			}
		}
		return $list;
	}
	
}
?>
