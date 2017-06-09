<?php
/**
 * BlockHelper
 * 
 * [Short Description]
 *
 * @package ui.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/

class BlockHelper extends AppHelper {

	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Ui.Media');

    public function pageTitle($options = [])
    {
        $code = $overlay = [];

        if (!empty($options['image'])) {
            $options['imageOptions']['class'] = 'mh-background-image';
            $code[] = $this->Media->image($options['image'], $options['imageOptions']);
        } else {
            $options['overlay'] = false;
        }


        if (!empty($options['overlay'])) {
            $headerOptions = $options;
            $headerOptions['class'] = 'mh-overlay';
            $code[] = $this->header($headerOptions);
        } else {
            $code[] = $this->header($options);
        }

        return $this->Html->div('mh-block-title', implode(chr(10), $code));
    }

    public function header($options = array())
	{
		$defaults = array(
			'title' => false,
			'tagline' => false,
			'logo' => false,
			'icon' => false,
			'link' => false, 
			'class' => 'mh-media'
		);
		
		extract(Set::merge($defaults, $options));
		$icon = $this->icon($icon);
		$text = $this->Html->div('mh-media-body', $this->title($title, $link) . chr(10) . $this->tagLine($tagline));
		return $this->Html->tag(
			'header',
			$this->logo($logo).$text,
			array('class' => $class)
		);
	}
	
	public function icon($icon)
    {
        if (!$icon) {
            return false;
        }

        return '<i class="fi-'.$icon.'"></i>';
    }

    private function title($title, $link)
    {
        if (!$title) {
            return false;
        }
        if ($link) {
            $title = $this->Html->link($title, $link);
        }

        return $this->Html->tag('h1', $title);
    }

	private function tagLine($tagline)
	{
		if (!$tagline) {
			return false;
		}
		return $this->Html->tag('h2', $tagline);
	}

	private function logo($logo)
	{
		if (!$logo) {
			return false;
		}
		return $this->Media->image($logo, array(
			'class' => 'mh-media-object',
			'size' => 'headerLogo'
		));

	}
	
}
