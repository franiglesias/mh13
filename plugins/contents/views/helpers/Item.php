<?php
/**
 * ItemHelper
 * 
 * [Short Description]
 *
 * @package default
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'SinglePresentationModel');

class ItemHelper extends SinglePresentationModelHelper implements AutoLinkable{
	var $var = 'item';
	var $model = 'Item';
	var $helpers = array('Html', 'Form', 'Ui.Media');
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->realStatuses = array(
			0 => __d('contents', 'draft', true),
			1 => __d('contents', 'review', true),
			2 => __d('contents', 'published', true),
			3 => __d('contents', 'expired', true),
			4 => __d('contents', 'retired', true),
			5 => __d('contents', 'waiting', true)
 		);

		$this->shortRealStatuses = array(
			0 => __d('contents', 'D', true),
			1 => __d('contents', 'R', true),
			2 => __d('contents', 'P', true),
			3 => __d('contents', 'E', true),
			4 => __d('contents', 'X', true),
			5 => __d('contents', 'W', true)
 		);
		$this->colorStatuses = array(
			0 => 'limited',
			1 => 'limited',
			2 => 'allowed',
			3 => 'undefined',
			4 => 'forbidden',
			5 => 'info'
 		);
	}
	/**
	 * Builds a class name for the item
	 *
	 * @param string $baseClass 
	 * @return string
	 * @author Fran Iglesias
	 */
	public function getClass($baseClass = false)
	{
		$class = $baseClass;
		if ($this->value('featured')) {
			$class .= ' featured';
		}
		if ($image = $this->DataProvider->getKeyDataSet('MainImage')) {
			$class .= ' has-image';
		}
		if ($this->hasKey('Download')) {
			$class .= ' has-download';
		}
		if ($this->hasKey('Multimedia')) {
			$class .= ' has-multimedia';
		}
		
		if ($this->value('stick')) {
			$class .= ' stick';
		}
		return trim($class);
	}
	
	/**
	 * full URL to himself
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function selfUrl()
	{
		return array(
			'plugin' => 'contents',
			'controller' => 'items',
			'action' => 'view',
			$this->value('slug'));
	}
	
/**
 * Returns the image tag
 *
 * @param string $imageSize 
 * @param string $options 
 * @return HTML string
 */	
	public function mainImage($imageSize, $options = array())
	{
		if (!$this->hasKey('MainImage')) {
			return false;
		}
		$image = $this->DataProvider->getKeyDataSet('MainImage');
		if (!$image) {
			return false;
		}
		$image = $image[0]['path'];
		$tag = $this->Media->image($image, array(
			'size' => $imageSize,
			'attr' => $options
		));
		return $tag;
	}
	
	public function listImage()
	{
		if (!$this->hasKey('MainImage')) {
			return false;
		}
		$image = $this->DataProvider->getKeyDataSet('MainImage');
		if (!$image) {
			return false;
		}
		$image = $image[0]['path'];
		return $this->Media->responsiveImage($image, 'AltListImage');
	}

	public function status()
	{
		if (!$this->value('expiration')) {
			return;
		}
		if (strtotime($this->value('expiration')) < time()) {
			$text = __d('contents', 'This item is expired, so information contained could be out of date or inaccurate. It is presented here for historic interest.', true);
			$text .= $this->Html->link('&times;', '#', array('class' => 'close', 'escape' => false));
			return $this->Html->tag('div', $text, array('class' => 'alert-box warning radius', 'data-alert' => true));
		}
	}
	
}