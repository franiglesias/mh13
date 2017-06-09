<?php
/**
 * UpComponent
 * 
 * A component to handle uploads
 *
 * @package subpackage.package
 * @version $Rev$
 * @license MIT License
 * 
 * $Id$
 * 
 * $HeadURL$
 * 
 **/


App::import('Vendor', 'FiId3');


class UpComponent extends Object {
	
/**
 * Routes map based in main mimetype. Routes are relative to webroot (or private
 * path if is the case)
 *
 * @var string
 */
	var $routes = array(
		'image' => 'img',
		);

	var $defaultRoute = 'files';
	var $normalize = false;
	
	public function dispatchFile($tmpFile, $settings = array())
	{
		$this->normalize = false;
		$settings = array_merge(
			array(
				'move' => 'route',
				'conflict' => 'rename',
				'return' => 'link'
			),
			$settings);
		// Compute destination
		$destination = $this->whereToMove($tmpFile, $settings['move']);
		// Resolve conflicts
		if ($settings['conflict'] == 'rename') {
			$destination = $this->resolveConflict($destination);
		}
		// Move file
		$result = $this->moveFile($tmpFile, $destination);
		if ($result) {
			if ($this->normalize) {
				$this->normalize($destination);
			}			
			return array(
				'success' => true,
				'error' => false,
				'file' => basename($destination),
				'fullPath' => $destination,
				'path' => $this->whatToReturn($destination, $settings['return']),
				'remark' => $settings['move']
			);
		}
		
		return array(
			'success' => false,
			'error' => sprintf(__d('uploads', 'Error moving file to %s', true), $destination),
			'file' => false,
			'fullPath' => $destination,
			'path' => $this->whatToReturn($destination, $settings['return']),
			'remark' => $settings['move']
		);
	}
	
/**
 * Computes where to Move a file given source path and options, uses source path
 * to get info of the file
 *
 * To avoid clutter and risks from excessive number of files, a daily timestamp is added
 *
 * @param string $source
 * @param string $options
 *
 * @return void
 */
	protected function whereToMove($source, $options) {
		switch ($options) {
			case 'private':
				$destination = Configure::read('Uploads.private');
				break;
			case 'route':
				$i = new FiId3();
				$info = $i->info($source);
				$mime = $info['type'];
				$this->log('Type: '.$mime, 'uploads');
				$destinationFolder = $this->defaultRoute;
				if ($mime) {
					list($type, $subtype) = explode('/', $mime);
					if (isset($this->routes[$type])) {
						$destinationFolder = $this->routes[$type];
                    }
					if ($type === 'image') {
						$this->normalize = true;
					}
                }
				$destination =  WWW_ROOT. $destinationFolder . DS;
				break;
			default:
				$destination = $options;
				break;
		}

		// Check to ensure trailing slash in path and add timestamp
		if ($destination[strlen($destination) -1] !== DS) {
			$destination .= DS;
		}
		$timestamp = date('Ymd');
		$destination .= $timestamp;

		// Attempt to create Folder if needed
		if (!file_exists($destination)) {
			$Folder = new Folder();
			if (!$Folder->create($destination)) {
				$this->log('[Up] Unable to create folder at '.$destination, 'uploads');
				return false;
			}
		}
		return $destination. DS . basename($source);
	}

/**
 * Computes a new name if a $destination points to an existing file
 *
 * @param string $destination
 *
 * @return string A new destination filePath
 */
	protected function resolveConflict($destination)
	{
		if (!file_exists($destination)) {
			return $destination;
		}

		// Adds a time-stamp in case of conflicting names to prevent long term conflicts

		$pathinfo = pathinfo($destination);
		extract($pathinfo);
		$timestamp = date('Y-m-d-H-i-s');
		$newName = $dirname . DS . $filename . '-' . $timestamp . '.' . $extension;

		if (file_exists($newName)) {
			return $this->resolveConflict($newName);
		}
		return $newName;
	}

/**
 * Move the file to its destination
 *
 * @param string $source
 * @param string $destination
 *
 * @return void
 */
    public function moveFile($source, $destination)
    {
        $File = new File($source);
        if (!$File->copy($destination, true)) {
			return false;
		}
        // $File->copy($destination, true);
        $File->delete();

        return true;
	}

    /**
 * Normalizes size of uploaded images to avoid fat files
 *
     * @param string $image
     *
 * @return void
 */
	public function normalize($image)
	{
		$settings = array(
			'method' => 'reduce',
			'width' => 640,
			'height' => 480
		);
		if ($defaults = Configure::read('Uploads.normalize')) {
			if (isset($defaults['method'])) {
				unset($defaults['method']);
			}
			$settings = array_merge($settings, $defaults);
		}
		App::import('Lib', 'FiImage');
		$Image = ClassRegistry::init('FiImage');
		return $Image->transform($image, $settings);

	}

    /**
     * Computes what value should be returned to the field data
     *
     * @param string $path
     * @param string $options
     *
     * @return void
     */
    public function whatToReturn($path, $options)
    {
        $options = strtolower($options);

        if (!in_array($options, array('path', 'link', 'id'))) {
            // error
            return false;
        }

        if ($options == 'path') {
            return $path;
        }

        if ($options == 'link') {
            $link = str_replace(WWW_ROOT, '', $path);
            // Suppress img dir if the file is in img, due to HtmlHelper->image
            $link = preg_replace('%^img/%', '', $link);

            return $link;
        }

        // Return data of attached upload
    }

    /**
     * Utility methods
     */

    public function computeDestination($upload, $settings)
    {
        $destination = $this->whereToMove($upload, $settings['move']);
        // Resolve conflicts
        if ($settings['conflict'] == 'rename') {
            $destination = $this->resolveConflict($destination);
        }

        return $destination;
    }
	

}


?>
