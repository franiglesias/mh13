<?php

App::import('Lib', 'fi_file/FiId3');
App::import('Lib', 'FiMime');
App::import('Lib', 'FiImage');
/**
* MediaHelper
*/
class MediaHelper extends AppHelper
{
	var $defaults = array(
		'width' => 450,
		'height' => 337
	);
	
	var $locations;
	
	var $helpers = array('Html', 'Number','Js');

/**
 * Basic types supported by the Helper
 * file is the default type
 *
 * @var array
 */	
	var $basicTypes = array(
		'image',
		'audio',
		'video'
	);

	public function __construct()
	{
		$this->locations['images'] = Configure::read('Uploads.base').'img/';
		$this->locations['files'] = Configure::read('Uploads.base').'files/';
	}
	public function setLocation($type, $location)
	{
		$this->locations[$type] = $location;
	}
	
/**
 * Utility methods
 *
 * @param string $path
 *
 * @return void
 */

	public function responsiveImage($path, $size = 'ListImage')
	{
		$Image = ClassRegistry::init('FiImage');
		$breaks = array_keys(Configure::read('Theme.sizes.'.$size));
		try {
			$imagePath = $this->getImagePath($path);
			$data = '';
			foreach ($breaks as $media) {
				$options = array_merge($this->getImageInfo($imagePath), $this->responsiveOptions($size, $media));
				$path = $this->linkToImage($Image->thumb($imagePath, $options));
				$data .= "[$path, ($media)],";
			}
		} catch (Exception $e) {
			$this->log('Unable to create Thumb for '.$path, 'media');
			return false;
		}
		unset($Image);
		return sprintf('<img data-interchange="%s" />', $data);
	}
	
/**
 * Get the Physical path to an image file taking care of theme and plugin settings
 *
 * @param string $path
 *
 * @return void
 */
	public function getImagePath($path)
	{
		$fullPath = '';
		if (!empty($path)) {
			if ($fullPath = $this->isPluginAsset($path)) {
				return $fullPath;
			}
			if ($fullPath = $this->isThemeAsset($path)) {
				return $fullPath;
			}
			$path = preg_replace('/^img\\'.DS.'/', '', $path);
			$fullPath = $this->locations['images'] . $path;
	 		if (file_exists($fullPath)) {
				return $fullPath;
			}
		}
		throw new RuntimeException(sprintf('Image file not present: %s.', $fullPath), 1);
	}

    /**
     * Gets the information for an image, using the Id3 class
     *
     * @param string $fullPath
     *
     * @return void
     */
    private function getImageInfo($fullPath)
    {
        $id3 = new FiId3($fullPath);
        $info = $id3->info();

        return [
            'width'  => $id3->info('width'),
            'height' => $id3->info('height'),
        ];
    }

    private function responsiveOptions($size, $media)
    {
        $options['width'] = Configure::read('Theme.sizes.'.$size.'.'.$media.'.width');
        $options['height'] = Configure::read('Theme.sizes.'.$size.'.'.$media.'.height');
        $options['method'] = Configure::read('Theme.sizes.'.$size.'.'.$media.'.method');

        return $options;
    }

    /**
     * Media viewers
     *
     */

    private function linkToImage($path)
    {
        $path = $this->getImageBase($path);
        if ($path[0] !== '/') {
            $path = IMAGES_URL.$path;
        }

        return $this->assetTimestamp($this->webroot($path));
    }

    /**
     * Checks if an image file is in a plugin webroot.
     *
     * @param string $path
     *
     * @return mixed string the fullpath if the image file exists. If not, false
     */
	public function isPluginAsset($path)
	{
		$parts = array();
		preg_match('~^/(.*)/'.IMAGES_URL.'(.*)$~',$path, $parts);
		if (!$parts) {
			return false;
		}
		$fullPath = APP . 'plugins' . DS . $parts[1] . DS . 'webroot' . DS . IMAGES_URL . $parts[2];
		if (file_exists($fullPath)) {
			return $fullPath;
		}
		return false;
	}

/**
 * Checks if an image file is in a theme webroot.
 *
 * @param string $path
 *
 * @return mixed string the fullpath if the image file exists. If not, false
 */
	public function isThemeAsset($path)
	{
		$path = preg_replace('/^img\\'.DS.'/', '', $path);
		$cakePath = $this->webroot(IMAGES_URL.$path);
		if (strpos($cakePath, 'theme') !== false) {
			$fullPath = VIEWS . 'themed' . DS . $this->theme . DS . 'webroot' . DS . IMAGES_URL . $path;
			if (file_exists($fullPath)) {
				return $fullPath;
			}
		}
		return false;
	}

    /**
     * Computes the path needed for HtmlHelper->image, taking care if the image is in a plugin
     *
     * @param string $fullPath
     *
     * @return string
     */
    public function getImageBase($fullPath)
    {
        $parts = array();
        preg_match('~^.*/plugins/(.*)/webroot/img/(.*)$~', $fullPath, $parts);
        if ($parts) {
            return '/'.$parts[1].'/img/'.$parts[2];
        }

        return preg_replace('%^.*'.IMAGES_URL.'%', '', $fullPath);
    }

    public function audio($path, $options = array())
    {
        # code...
    }

    public function video($path, $options = array())
    {
        # code...
    }

    /**
     * Shows a list of files for download
     *
     * @param string $files
     * @param string $options
     *
     * @return HTML code
     */
    public function fileList($files, $options = array('id' => 'files'))
    {
        echo $this->Html->css('skin/download-links', null, array('inline' => false));
        $options['delete'] = false;
        if (!is_numeric(key($files))) {
            if (empty($files['id'])) {
                return false;
            }
            $files = array($files);
        }
        $code = array();
        foreach ($files as $file) {
            if (empty($file['id'])) {
                continue;
            }
            $fileOptions['id'] = $file['id'];
            $fileOptions['delete'] = $options['delete'];
            $fileOptions['name'] = $file['name'];
            $fileOptions['description'] = $file['description'];
            $line = $this->file($file['path'], $fileOptions);
            $code[] = $this->Html->tag('li', $line, array('class' => 'media mh-download-list-item'));
        }
        $ret = implode(chr(10), $code);
        $ret = $this->Html->tag('ul', $ret, array('class' => 'mh-download-list'));

        return $ret;
    }
	
/**
 * File viewer builds an object to show links for file uploads/download in a rich and informative fashion. The generated code must be enclosed in element with class "media" or subclass
 *
 * @param string $path
 * @param string $options
 *
 * @return string HTML code to be enclosed in class "media" HTML element
 */
	public function file($path, $options = array())
	{
		if ($this->isPrivate($path)) {
			$path = preg_replace('%^'.Configure::read('Uploads.private').'%', '', $path);
			$url = array(
				'plugin' => 'uploads',
				'controller' => 'uploads',
				'action' => 'download',
				$path
			);
		} else {
			$path = preg_replace('%^'.WWW_ROOT.'%', '', $path);
			$url = $this->Html->url('/'.$path, true);
		}
		$id3 = new FiId3($path);
		$info = $id3->info();
		if (!empty($options['name'])) {
			$info['name'] = $options['name'];
		}
		$theName = $this->Html->tag('strong', $this->humanize($info['name']));
		if (!empty($options['label'])) {
			$theName = $this->Html->tag('strong', $options['label']);
			unset($options['label']);
		}
		$theType = $this->humanFileType($path);
		$theSize = $this->Number->toReadableSize($info['size']);

		$theTitle = sprintF('Download %s of type %s (%s)', $theName, $theType, $theSize);
		if (!empty($options['description'])) {
			$theName .= $this->Html->tag('br').$options['description'];
		}
        // Build textual information
		$body =  $this->Html->tag('span', $theName, array('class' => 'mh-download-list-data-name'));
		$body .= $this->Html->tag('span', $theSize, array('class' => 'media-object-alt mh-download-list-data-size'));
		$body .= $this->Html->tag('span', $theType, array('class' => 'media-object-alt mh-download-list-data-type'));
		$body =  $this->Html->tag('span', $body, array('class' => 'media-body mh-download-list-data'));


		$preview = $this->preview($path, array('size' => 'menuIcon', 'attr' => array('class' => 'media-object mh-download-list-preview')));

		if (!empty($options['label'])) {$label = $options['label'];}

		// Build basic link
		$link = $this->Html->link(
            $preview.$body,
            $url,
            array(
                'escape' => false,
                'class' => 'media mh-download-list-link',
				'title' => $theTitle
			));

		// Build delete button if requested
		$delete = '';
		// if (!empty($options['delete']) && $options['delete'] === true) {
		// 	$delete = $this->Html->link(
		// 		__d('uploads', 'X', true),
		// 		array(
		// 			'plugin' => 'uploads',
		// 			'controller' => 'uploads',
		// 			'action' => 'delete',
		// 			$options['id']
		// 		),
		// 		array(
		// 			'class' => 'confirm_delete button media-object-alt mh-download-list-delete',
		// 			'title' => sprintf('Delete file %s', $theName),
		// 		));
		// }
		return 	$delete.$link;
	}

    /**
     * Returns true if a file is stored in the private path
     *
     * @param string $path
     *
     * @return void
     */
    public function isPrivate($path)
	{
        return preg_match('%^'.Configure::read('Uploads.private').'%', $path);
	}

    /**
     * Converts a mess of under_scored and cameLized string into a readable Title Case one
     *
     * @param string $fileName
     *
     * @return string The Title
     */
    public function humanize($fileName)
	{
        return Inflector::humanize(mb_strtolower(Inflector::underscore($fileName)));
	}

/**
 * Uses FiMime to return a Human Readable File Type
 *
 * @param string $path
 *
 * @return string type
 */
    public function humanFileType($path)
	{
        $Mime = ClassRegistry::init('FiMime');
        $ret = $Mime->humanType($path);
        unset($Mime);
		return $ret;
	}

    /**
     * Creates a preview image for the file. A thumbnail for images and a icon for the rest of files if exists a png
     * file with the same name
     *
     * @param string $path
     * @param string $size
     *
     * @return string HTML code to show image
     */
    public function preview($path, $options = 'uploadPreviewImage')
    {
        if (empty($path)) {
            return false;
        }

        if (is_string($options)) {
            $options = array('size' => $options);
        }
        if (!isset($options['attr']['class'])) {
            $options['attr']['class'] = 'media-object';
        }
        $type = $this->isType($path);

        if ($type == 'image') {
            return $this->image($path, $options);
        }

        if ($options['size'] == 'uploadPreviewImage') {
            $options['size'] = 'previewIcon';
        }
        if ($preview = $this->image('/ui/img/assets/'.$type.'.png', $options)) {
            return $preview;
        }

        return $this->image('/ui/img/assets/file.png', $options);
    }

    /**
     * Returns a simplified generic type for a file (audio, video, image or file)
     *
     * @param string $path
     *
     * @return string file|image|audio|video
     */
    public function isType($path)
    {
        return ClassRegistry::init('FiMime')->simpleType($path);
    }

    /**
     * Creates an image tag with dimensions and allowing basic transformations.
     * The result links to a version of the image
     * adapted to the parameters and options passed (size, cropping...), the original is left untouched
     *
     * @param string $path
     * @param string $options array with keys
     *                        'size' => a preset from the theme_settings.php file
     *                        'rebuild' => image url forces reload, avoids browser cache
     *                        'method' => reduce/fit/scale/fill the method to adjust image to dimensions
     *                        'width' (px)
     *                        'height' (px)
     *
     * @return string HTML tag for the image
     */
    public function image($path, $options = array('rebuild' => true))
    {
        $Image = ClassRegistry::init('FiImage');
        try {
            $imagePath = $this->getImagePath($path);
            $options = array_merge($this->getImageInfo($imagePath), $this->setSizeOptions($options));
            $thumbPath = $Image->thumb($imagePath, $this->setImageProcessorOptions($options));
        } catch (Exception $e) {
            $this->log('Unable to create Thumb for '.$path, 'media');

            return false;
        }
        $thumbPath = $this->getImageBase($thumbPath);
        $attr = array(
            'alt' => basename($path),
            'width' => $Image->data['width'],
            'height' => $Image->data['height'],
        );
        if (!isset($options['attr'])) {
            $options['attr'] = array();
        }
        if (!empty($options['class'])) {
            $options['attr']['class'] = $options['class'];
        }
        $attr = array_merge($attr, $options['attr']);
        if (!empty($options['size']) && $options['size'] == 'none') {
            unset($attr['width']);
            unset($attr['height']);
        }
        if ($this->shouldRebuildImage($options)) {
            $thumbPath .= '?'.time();
        }
        unset($Image);

        return $this->Html->image($thumbPath, $attr);
    }

    private function setSizeOptions($options)
    {
        if (!empty($options['size']) && $options['size'] != 'none') {
            $options['width'] = Configure::read('Theme.sizes.'.$options['size'].'.width');
            $options['height'] = Configure::read('Theme.sizes.'.$options['size'].'.height');
            $options['method'] = Configure::read('Theme.sizes.'.$options['size'].'.method');
        }

        return $options;
    }

    private function setImageProcessorOptions($options)
    {
        $keys = array(
            'method' => 'reduce',
            'width' => false,
            'height' => false,
            'filter' => false,
            'dirname' => false,
            'cache' => !empty($options['rebuild']),
        );

        return array_merge($keys, array_intersect_key($options, $keys));
    }

    private function shouldRebuildImage($options)
    {
        return (!empty($options['rebuild']) || !isset($options['rebuild']));
    }

	public function downloads($files, $options = array())
	{
		if (!is_numeric(key($files))) {
			if (empty($files['id'])) {
				return false;
			}
			$files = array($files);
		}
		$code = array();
		foreach ($files as $file) {
			if(empty($file['id'])) {
				continue;
			}
			$fileOptions['id'] = $file['id'];
			$fileOptions['name'] = $file['name'];
			$fileOptions['description'] = $file['description'];
			$line = $this->download($file['path'], $fileOptions);
			$code[] = $this->Html->tag('li', $line, array('data-equalizer-watch' => 1));
		}
		$ret = implode(chr(10), $code);
		$ret = $this->Html->tag('ul', $ret, array('class' => 'mh-download-list', 'data-equalizer' => 1));
		return $ret;
	}

	public function download($path, $options = array())
	{
		if ($this->isPrivate($path)) {
			$path = preg_replace('%^'.Configure::read('Uploads.private').'%', '', $path);
			$url = array(
				'plugin' => 'uploads',
				'controller' => 'uploads',
				'action' => 'download',
				$path
			);
		} else {
			$path = preg_replace('%^'.WWW_ROOT.'%', '', $path);
			$url = $this->Html->url('/'.$path, true);
		}
		$id3 = new FiId3($path);
		$info = $id3->info();
		if (!empty($options['name'])) {
			$info['name'] = $options['name'];
		}
		$theName = $this->Html->tag('strong', $this->humanize($info['name']));
		if (!empty($options['label'])) {
			$theName = $this->Html->tag('strong', $options['label']);
			unset($options['label']);
		}
		$theType = $this->humanFileType($path);
		$theSize = $this->Number->toReadableSize($info['size']);
		
		$theTitle = sprintF('Download %s of type %s (%s)', $theName, $theType, $theSize);
		if (!empty($options['description'])) {
			$theName .= $this->Html->tag('br').$options['description'];
		}
		// Build button
		$preview = $this->preview($path, array('size' => 'directLinksIcon'));
		$body =  $this->Html->tag('div', $preview);
		$data =  $this->Html->tag('span', $theName, array('class' => 'mh-download-name'));
		$data .= $this->Html->tag('span', $theSize, array('class' => 'mh-download-size'));
		$data .= $this->Html->tag('span', $theType, array('class' => 'mh-download-type'));
		$body .= $this->Html->tag('div', $data);
		if (!empty($options['label'])) {$label = $options['label'];}
		
		// Build basic link
		$link = $this->Html->link(
			$body, 
			$url, 
			array(
				'escape' => false, 
				'class' => 'mh-download-button', 
				'title' => $theTitle
			));

		return 	$link;
	}

	
}


?>
