<?php
/**
 * Image class
 * 
 * Simple Image utility class to help in cropping, scaling and resizing images to
 * fit in a predetermined area.
 * 
 * Actually based on GD graphics library. 
 *
 * @package image.lib.milhojas
 * @version $Rev: 383 $
 * @license MIT License
 * 
 * $Id: image.php 383 2010-01-04 14:34:06Z franiglesias $
 * 
 * $HeadURL: http://franiglesias@subversion.assembla.com/svn/milhojas/vendors/image.php $
 * 
 **/
if (!defined('DS')) {
	define('DS', '/');
}

if (!defined('IMAGES')) {
	define('IMAGES', getcwd().DS);
}

if (!defined('WWW_ROOT')) {
	define('WWW_ROOT', getcwd().DS);
}

if (!defined('LOGS')) {
	define('LOGS', getcwd().DS);
}


class FiImage
{
	/**
	 * Image stream
	 *
	 * @var string
	 */
	var $image;
	/**
	 * The path of the image file, relative to $this->imagesPath
	 *
	 * @var string
	 */
	var $filename;
	/**
	 * Basic image data widht, height, mime
	 *
	 * @var array
	 */
	var $data;

	// Options

	/**
	 * base path for images, trailing DS
	 *
	 * @var string
	 */
	var $imagesPath;
	/**
	 * If true, use them created images as cache for newest with the same characteristics
	 *
	 * @var boolean
	 */
	var $cache = true;
	/**
	 * Full path to the log file
	 *
	 * @var string
	 */
	var $log;
	/**
	 * What to log
	 *
	 * 0: nothing
	 * 1: only errors
	 * 2: all (include errors, cache, etc.)
	 * @var integer
	 */
	var $logLevel = 0;
	
	var $webroot;

	var $textDefaults = array(
		'fontsPath' => '',			// Where to find font files
		'size' => 12,				// Font size in points
		'font' => 'Arial',			// Fontface
		'color' => 'FFFFFF',		// Text color
		'background' => '000000',	// Background color
		'pad' => 8					// Padding, space between the text and the border of canvas
		);
	
	/**
	 * Array of method names that can be used to manipulate image
	 *
	 * @var string
	 */
	var $methods = array(
		'fit',		//(by default): scales and crop the image to fit dimensions, 
		'reduce',	//the same as fit but only if the image is bigger than dimensions.
		'bfit',		// same as fit but creates a background color to fill dimensions
		'fill',		// scales the image to fill dimensions not keeping aspect ratio, 
		'scale',	// scales the image	
	);
	
	var $defaultMethod = 'fit';
		
	var $effects = array(
		'blur' => array(
			'filter' => IMG_FILTER_GAUSSIAN_BLUR,
			'params' => array(
				'quantity' => true,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => false
			),
		),
		'soft' => array(
			'filter' => IMG_FILTER_SMOOTH,
			'params' => array(
				'quantity' => false,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => true
			),
		),
		'grayscale' => array(
			'filter' => IMG_FILTER_GRAYSCALE,
			'params' => array(
				'quantity' => false,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => false
			),
		),
		'brighten' => array(
			'filter' => IMG_FILTER_BRIGHTNESS,
			'params' => array(
				'quantity' => false,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => true
			),
		),
		'darken' => array(
			'filter' => IMG_FILTER_BRIGHTNESS,
			'params' => array(
				'quantity' => false,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => true
			),
		),
		'contrast' => array(
			'filter' => IMG_FILTER_CONTRAST,
			'params' => array(
				'quantity' => false,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => true
			),
		),
		'sketch' => array(
			'filter' => IMG_FILTER_MEAN_REMOVAL,
			'params' => array(
				'quantity' => true,
				'color' => false,
				'alpha' => false,
				'mode' => false,
				'level' => false
			),
		)
		
	);
	
	function __construct($filename = false, $options = array()) {
		$this->filename = $filename;
		$this->image = null;
		$this->setOptions($options);
		$this->textDefaults['fontsPath'] = $this->fontsPath;
	}
	
	/**
	 * Set default options
	 *
     * @param string $options
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function setOptions($options = array())
	{
		$defaults = array(
			'fontsPath' => WWW_ROOT.'fonts',
			'imagesPath' => IMAGES,
			'log' => LOGS.'fi_image.log',
			'logLevel' => 1,
			'cache' => true,
			'method' => 'fill'
		);
		foreach ($defaults as $key => $value) {
			if (isset($options[$key])) {
				$this->$key = $options[$key];
			} else {
				$this->$key = $value;
			}
		}
	}
	
	public function setDefault($param, $value = false)
	{
		switch ($param) {
			case 'method':
				if (in_array($value, $this->methods)) {
					$this->defaultMethod = $value;
				}
				break;
			
			default:
				# code...
				break;
		}
	}
	
/**
 * Alias for read
 *
 * @param string $filename
 *
 * @return void
 */
    function load($filename)
    {
        return $this->read($filename);
	}

/**
 * Reads an image from a file in the filesystem. Throws an exception if file doesn't exist
 * or if file is not an image. Load the data var with width, height and type of the
 * image. PNG images supports alpha transparency
 *
 * @param string $filename
 *
 * @return void
 */	
	function read($filename) {
		if (!file_exists($filename)) {
			$message = sprintf('Image file %s not found.', $filename);
			$this->log($message, 'error');
			throw new RuntimeException($message);
			return false;
		}
		$this->filename = $filename;
		$extra = array();
		$info = getimagesize($filename, $extra);
		$this->data = array(
			'width' => $info[0],
			'height' => $info[1],
			'type' => $info['mime']
 			);
		switch ($info['mime']) {
			case 'image/jpeg':
				$this->image = imagecreatefromjpeg($filename);
				break;
			case 'image/png':
				$this->image = imagecreatefrompng($filename);
				break;
			case 'image/gif':
				$this->image = imagecreatefromgif($filename);
				break;
			default:
				$message = sprintf('Image type unsupported or not image file: %s', $filename);
				$this->log($message, 'error');
				throw new OutOfBoundsException($message);
				return false;
				break;
		}
		imagealphablending($this->image, true); // setting alpha blending on
		imagesavealpha($this->image, true); // save alphablending setting (important)
	}

/**
 * Log
 *
 * @param string $message
 * @param string $type , type of message alert|error|cache
 *
 * @return void
 */
    public function log($message, $type = 'alert')
    {
        if (!$this->logLevel) {
            return;
        }
        if ($this->logLevel == 1 && $type != 'error') {
            return;
        }

        return file_put_contents($this->log, date('Y-m-d H:i').' ['.$type.'] '.$message.chr(10), FILE_APPEND);
	}
	
/**
 * Alias for write
 *
 * @param string $filename
 *
 * @return void
 */
    function save($filename)
    {
        return $this->write($filename);
	}

/**
 * Stores the image in the filesystem
 *
 * @param string $filename
 *
 * @return void
 */
	function write($filename) {
		$this->filename = $filename;
		list($type, $subtype) = explode('/', $this->data['type']);
		$method = 'image'. $subtype;
		$path = dirname($filename);
		if (!file_exists($path)) {
			$success = @mkdir($path, 0777, true);
			if (!$success) {
				$message = sprintf("Can\'t create the needed directory %s.", $path);
				$this->log($message, 'error');
				throw new RuntimeException($message);
			}
		}
		$success = @$method($this->image, $filename); // Make error non-verbose
		if (!$success) {
			$message = sprintf("Can\'t create the image %s.", $filename);
			$this->log($message, 'error');
			throw new RuntimeException($message);
		}
	}

/**
 * Proportionally scales an image to fit in a given size, but creates a background to produce a image with that exactly size
 *
 * @param string $width
 * @param string $height
 *
 * @return void
 * @author Fran Iglesias
 */
	function bfit($width = 0, $height = 0, $background = 'FFFFFF') {
		$dX = $width / $this->data['width'];
		$dY = $height / $this->data['height'];
		if ($dX > $dY) {
			$dX = $dY;
		} else {
			$dY = $dX;
		}
		$dWidth = $this->data['width'] * $dX;
		$dHeight = $this->data['height'] * $dY;
		$canvas = $this->canvas($width, $height, $background);
		$x = ($width-$dWidth) / 2;
		$y = ($height-$dHeight) / 2;
		$result = imagecopyresampled($canvas, $this->image, $x, $y, 0, 0, $dWidth, $dHeight, $this->data['width'], $this->data['height']);
		$this->image = $canvas;
		unset($canvas);
		$this->refresh();

        return $result;
    }

    /**
     * Creates a basic true color image to act as canvas to draw the resulting images
     * over
     *
     * @param string $width
     * @param string $height
     * @param string $color
     * @param string $alpha false to avoid text artifacts
     *
     * @return void
     */
    public function canvas($width, $height, $color = 0, $alpha = true)
    {
        $canvas = imagecreatetruecolor($width, $height);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefill($canvas, 0, 0, $color);
        imagecolortransparent($canvas, $color);

        return $canvas;
    }

    /**
     * An utility method to sync real data with meta data after transformations
     *
     * @return void
     */
    protected function refresh()
    {
        $this->data = array(
            'width' => imagesx($this->image),
            'height' => imagesy($this->image),
            'type' => $this->data['type'],
        );
    }

    /**
     * Scale the image only if it's bigger than target dimensions
     *
     * @param string $width
     * @param string $height
     *
     * @return void
     */
    function reduce($width, $height)
    {
        if ($this->data['width'] <= $width && $this->data['height'] <= $height) {
            return;
        }
        $this->fit($width, $height);
        $this->refresh();
    }

/**
 * Recompute image size so the image fits in the target
 *
 * @param string $width
 * @param string $height
 * @param string $mode
 *
 * @return void
 */
	function fit($width, $height) {
		$dX = $width / $this->data['width'];
		$dY = $height / $this->data['height'];
		if ($dX > $dY) {
			$dX = $dY;
		} else {
			$dY = $dX;
		}
		$dWidth = $this->data['width'] * $dX;
		$dHeight = $this->data['height'] * $dY;
		$this->scale($dWidth, $dHeight);
		$this->refresh();
    }
	
/**
 * Scales the image to the given size without respecting the aspect ratio.
 * If any dimension is 0 (zero), the scaling keeps the aspect ratio and the
 * provided dimension is used for calculations
 *
 * @param string $width
 * @param string $height
 *
 * @return void
 */
    function scale($width = 0, $height = 0)
    {
        if ($height == 0) {
            $dY = $dX = $width / $this->data['width'];
        } elseif ($width == 0) {
            $dY = $dX = $height / $this->data['height'];
        } else {
            $dX = $width / $this->data['width'];
            $dY = $height / $this->data['height'];
        }
        $dWidth = intval($this->data['width'] * $dX);
        $dHeight = intval($this->data['height'] * $dY);
        $canvas = $this->canvas($dWidth, $dHeight, 'FFFFFF');
        $result = imagecopyresampled(
            $canvas,
            $this->image,
            0,
            0,
            0,
            0,
            $dWidth,
            $dHeight,
            $this->data['width'],
            $this->data['height']
        );
        $this->image = $canvas;
        unset($canvas);
		$this->refresh();

        return $result;
	}

/**
 * Scale the image so it fills completely the target dimensions, cropping
 *
 * @param string $width
 * @param string $height
 *
 * @return void
 */
	function fill($width, $height) {
		$dX = $width / $this->data['width'];
		$dY = $height / $this->data['height'];
		if ($dX < $dY) {
			$dX = $dY;
		} else {
			$dY = $dX;
		}
		$dWidth = $this->data['width'] * $dX;
		$dHeight = $this->data['height'] * $dY;
		$this->scale($dWidth, $dHeight);
		$this->crop($width, $height);
		$this->refresh();
    }

    /**
     * Crops an image to the given size. Modes can be set using
     *
     * top
     * middle
     * bottom
     *
     * left
     * center
     * right
     *
     * to specify where to anchor the crop area. Default is center middle
     *
     * @param string $width
     * @param string $height
     * @param string $mode
     *
     * @return void
     */
    function crop($width, $height, $mode = 'center middle')
    {
        $horizMode = trim(preg_replace('/top|middle|bottom/', '', $mode));
        $vertMode = trim(preg_replace('/left|center|right/', '', $mode));

        switch ($horizMode) {
            case 'left':
                $x = 0;
                break;
            case 'right':
                $x = $this->data['width'] - $width;
                break;
            default:
                $x = ($this->data['width'] - $width) / 2;
                break;
        }

        switch ($vertMode) {
            case 'top':
                $y = 0;
                break;
            case 'bottom':
                $y = $this->data['height'] - $height;
                break;
            default:
                $y = ($this->data['height'] - $height) / 2;
                break;
        }

        return $this->cropXY($x, $y, $width, $height);
    }

    /**
     * Crops an image to a given size from given coordinates
     *
     * @param string $x      X origin
     * @param string $y      Y origin
     * @param string $width  The desired width
     * @param string $height The desired height
     *
     * @return the image cropped
     */
    function cropXY($x, $y, $width, $height)
    {
        $canvas = $this->canvas($width, $height, 'FFFFFF');
        $result = imagecopyresampled($canvas, $this->image, 0, 0, $x, $y, $width, $height, $width, $height);
        $this->image = $canvas;
        unset($canvas);
        $this->refresh();

        return $result;
    }

/**
 * Merges an image into the main image as a watermark
 *
 * @param resource $mark The image to use as watermark
 * @param string   $place
 *
 * @return void
 */
	function watermark($mark, $place = "top left", $opacity = 100) {
		$width = imagesx($mark);
		$height = imagesy($mark);

		switch ($place) {
			case 'top left':
				$x = 0;
				$y = 0;
				break;
			case 'top right':
				$x = imagesx($this->image) - $width;
				$y = 0;
				break;
			case 'bottom right':
				$x = imagesx($this->image) - $width;
				$y = imagesy($this->image) - $height;
                break;
			case 'bottom left':
				$x = 0;
				$y = imagesy($this->image) - $height;
				break;
		}

		imagecopymerge($this->image, $mark, $x, $y, 0, 0, $width, $height, $opacity);
	}

/**
 * Poorly implemented, don't use for the moment
 *
 * @param string $text
 * @param string $options
 *
 * @return void
 */
	function text($text, $options = array()) {
		$info = gd_info();
		if (!isset($info['FreeType Support']) || empty($info['FreeType Support'])) {
			return false;
		}
		$options = array_merge($this->textDefaults, $options);
		$font = $options['fontsPath'] . DS . $options['font'];
		$theBox = imagettfbbox($options['size'], 0, $font, $text);
		$width = $options['pad'] * 2 + $theBox[2] - $theBox [0];
		$height = $options['pad'] * 2 + $theBox[3] - $theBox[5];
		$canvas = $this->canvas($width, $height, $this->color($options['background']), false);
		imagettftext($canvas, $options['size'], 0, $options['pad'], $height-$options['pad'], $this->color($options['color']), $font, $text);
		return $canvas;
    }

    /**
     * Creates a color to use in images from a string with the hex form used in CSS color
     * definitions
     *
     * @param string $colorHex
     *
     * @return the color
     */
    public function color($colorHex)
    {
        if ($colorHex[0] == '#') {
            $colorHex = substr($colorHex, 1);
        }
        $image = imagecreatetruecolor(10, 10);
        $color = imagecolorallocate(
            $image,
            hexdec('0x'.$colorHex{0}.$colorHex{1}),
            hexdec('0x'.$colorHex{2}.$colorHex{3}),
            hexdec('0x'.$colorHex{4}.$colorHex{5})
        );

        return $color;
	}

/**
 * High level utility method to create thumbnails and save it in one step and return
 * valid path to pass to HtmlHelper::image. Main usage in views to draw a preview
 * to image files or to print images in the page in a given size but keeping the
 * original untouched. In fact, you can enlarge or reduce the image size, so thumb
 * is a sort of limited name for this method.
 *
 * Options:
 *
 * method: (string)
 *     'fit' (by default): scales and crop the image to fit dimensions,
 *     'fill': scales the image to fill dimensions not keeping aspect ratio,
 *     'reduce': the same as fit but only if the image is bigger than dimensions.
 *				 Fit and Reduce methods combine a scaling and a cropping action.
 *     'bfit': same as fit but creates a background color to fill dimensions
 *     'scale': scales the image
 *
 * prefix: (string) prefix to prepend to the name of the generated thumb file (default: thumb)
 *
 * width: (integer) desired width of the thumb (defs: 100px)
 *
 * height: (integer) desired height of the thumb (defs: 75px)
 *
 * dirname: (string) destination path for the thumbnail
 *
 * format: (string) a template string to format the name of the resulting image,
 * defaults to ':dirname:prefix_:width_:height_:basename'. See the CakePHP String::insert()
 * documentation
 *
 * cache: (boolean) use a previous thumb if exists
 *
 */

	function thumb($imageFile, $options = array()) {
		// Create the thumb name
		$defaults = array(
			'method' => $this->defaultMethod,
			'prefix' => 'thumb',
			'width' => 100,
			'height' => 75,
			'img' => false,
			'filter' => null,
			'dirname' => null,
			'cache' => $this->cache
			);

		$options = array_merge($defaults, $options);
		$options['method'] = $this->method($options['method']);

		$workingImage = $this->image_exists($imageFile, $options['dirname']);
		if (!$workingImage) {
			return false; // image doesn't exists
		}
		$p = pathinfo($imageFile);
		// Compute a name for the thumb image
		$newImage = $this->thumbName($p['basename'], $options);
		if (empty($options['dirname'])) {
			// Compute the path we should return
			$return = $p['dirname'] . DS . $newImage;
			$p = pathinfo($workingImage);
			$newImage = $p['dirname'] . DS . $newImage;
		} else {
			$return = $newImage;
		}
		// Use cache
		if ($this->cache && file_exists($newImage) && !empty($options['cache'])) {
			$this->log(sprintf('Image %s read from cache', $newImage), 'cache');
			$this->read($newImage);
			$this->refresh();
			return $return;
		}
		// Create the thumb using the method
		$this->reset();
		$this->read($workingImage);
		$this->{$options['method']} ($options['width'], $options['height']);
		$this->filter($options['filter']);
		$this->write($newImage);
		$this->refresh();
		return $return;
    }

    /**
     * Returns a valid method given a method string name
     *
     * @param string $method
     *
     * @return void
     * @author Fran Iglesias
     */
    public function method($method = false)
    {
        $method = strtolower($method);
        if (!in_array($method, $this->methods)) {
            $method = $this->defaultMethod;
        }

        return $method;
    }

    /**
     * This method checks if exists an image in the $imageFile path.
     *
     * If the path is relative, we transform into an absolute path using the constant
     * IMAGES if defined. If not, we get the current working directory
     *
     * Use of IMAGES constant enables this class to manipulate images a la CakePHP
     *
     * @param string $imageFile
     *
     * @return string absolute path to the image file, false if it doesn't exists
     */
    protected function image_exists($imageFile, $imagesPath = false)
    {
        if ($imageFile[0] == DS) {
            if (file_exists($imageFile)) {
                return $imageFile;
            } else {
                return false;
            }
        }

        if (!$imagesPath) {
            if (defined('IMAGES')) {
                $imagesPath = IMAGES;
            } else {
                $imagesPath = getcwd().DS;
            }
        }

        $imageFile = $imagesPath.$imageFile;
        if (file_exists($imageFile)) {
            return $imageFile;
        }

        return false;
    }

    /**
 * Builds a name for the thumb
     *
     * @param string $imageFile
     * @param string $options
 *
 * @return void
 */	
	public function thumbName($imageFile, $options = array()) {
		$defaultOptions = array(
			'dirname' => '',
			'prefix' => '',
			'width' => '',
			'height' => '',
			'filter' => '',
			'basename' => '',
			'method' => ''
			);
		$options = array_merge($defaultOptions, $options);
		if (empty($options['format'])) {
			$options['format'] = ':dirname:prefix/:width_:height/:method_:filter_:basename';
		}
		if (!empty($options['filter'])) {
			$options['filter'] = implode('_', array_keys($options['filter']));
		}
		if ($options['dirname']) {
			$dirname = $options['dirname'];
		} else {
			$dirname = dirname($imageFile);
		}
		if ($dirname[strlen($dirname) - 1] !== DS) {
			$dirname .= DS;
		}
		if ($dirname == '.'.DS) {
			$dirname = '';
		}
		
		$elements = array('dirname' => $dirname , 'basename' => basename($imageFile));
        $elements = array_merge($options, $elements);

        return CakeString::insert($options['format'], $elements);
    }

    /**
     * Utility method to reset the image, free memory and start from scratch
     *
     * @return void
     */
    public function reset()
    {
        unset($this->image);
        $this->image = null;
        $this->filename = false;
        $this->data = array();
    }

    /**
     * Apply an array of filters to the image
     *
     * @param string $filters
     *
     * @return boolean
     */
    public function filter($filters = null)
    {
        if (!$filters) {
            return false;
        }
        if (!is_array($filters)) {
            $filters = array($filters);
        }
        $success = true;
        foreach ($filters as $filter => $options) {
            if (is_string($options)) {
                $filter = $options;
                $options = array();
            }
            if (!isset($this->effects[$filter])) {
                continue;
            }

            $theFilter = $this->effects[$filter]['filter'];
            $params = $this->effects[$filter]['params'];

            if (!is_array($options)) {
                if ($params['level']) {
                    $options = array('level' => $options);
                } else {
                    $options = array('quantity' => $options);
                }
            }

            $params = array_intersect_key($options, $params);

            $quantity = 1;
            if (!empty($params['quantity'])) {
                $quantity = $params['quantity'];
            }
            $level = 0;
            if (!empty($params['level'])) {
                $level = $params['level'];
            }
            // $ok = imagefilter($this->image, $filter);
            for ($i = 0; $i < $quantity; $i++) {
                $ok = imagefilter($this->image, $theFilter, $level);
                if (!$ok) {
                    $success = false;
                }
            }
        }

        return $success;
    }
	
/**
 * Modifies a given image file the same as thumb does, options are the same except
 * that prefix is ignored, given that transform operates on the image file. Useful
 * when uploading an image and you want to normalize its size or adapt it to a given
 * design spec (like a layout, etc).
 *
 * @param string $imageFile
 * @param string $options
 *
 * @return void
 */
	public function transform($imageFile, $options = array()) {
		$defaults = array(
			'method' => $this->defaultMethod,
			'width' => 100,
			'height' => 75,
			'filter' => null,
			'dirname' => null
			);
		$options = array_merge($defaults, $options);

		$options['method'] = $this->method($options['method']);

		$imageFile = $this->image_exists($imageFile);
		if (!$imageFile) {
			return false;
        }

		// Transform using the method
		$this->reset();
		$this->read($imageFile);
		$this->{$options['method']} ($options['width'], $options['height']);
		$this->filter($options['filter']);
		$this->write($imageFile);
		$this->reset();
		return $imageFile;
	}
	
/**
 * Rotates an image file
 *
 * @param string $imageFile
 * @param string $degrees
 *
 * @return the image rotated
 */
	public function rotate($imageFile, $degrees = 90) {
		$imageFile = $this->image_exists($imageFile);
		if (!$imageFile) {
			return false;
		}
		// Transform using the method
		$this->reset();
		$this->read($imageFile);
	    imagealphablending($this->image, false);
	    imagesavealpha($this->image, true);
		$this->image = imagerotate($this->image, $degrees, imageColorAllocateAlpha($this->image, 0, 0, 0, 127), 0);
		imagealphablending($this->image, false);
	    imagesavealpha($this->image, true);
		$this->write($imageFile);
		$this->reset();
		// Force delete cached versions
		$this->resetCache($imageFile);
		return $imageFile;
	}
	
	public function resetCache($imageFile)
	{
		$pattern  = '/_'.str_replace('.', '\.', basename($imageFile)).'$/';
		$files = $this->readDir($this->imagesPath, $pattern);
		foreach ($files as $file) {
			unlink($file);
		}
    }

	public function readDir($dir, $pattern = false) {
		$handle = opendir($dir);
		if (!$handle) {
			return false;
		}
		$files = array();
		while(($file = readdir($handle)) !== FALSE) {
			if ($file[0] == '.') {
				continue;
			}
			$path = $dir.$file;
			if (is_dir($path)) {
				$files = array_merge($files, $this->readDir($path.DS, $pattern));
			} else {
				if ($pattern) {
					if (!preg_match($pattern, $file, $matches)) {
						continue;
					}
				}
				$files[] = $path;
			}
		}
		return $files;
    }
}


?>
