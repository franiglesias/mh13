<?php

App::import('Lib', 'FiMime');
App::import('Lib', 'Uploads.interfaces/FileDispatcherInterface');
App::import('Lib', 'Uploads.interfaces/DispatchedFileInterface');


class FileDispatcher implements FileDispatcherInterface
{
	private $Mime;
	private $File;
	private $routes;
	private $default = 'files';
	private $subRoutes = array();
	private $basePaths = array();
	private $move = true;
	private $routing = 'route';
	
	# Constructor section
	
	function __construct($routeBase, $privateBase = null)
	{
		$this->Mime = new FiMime();
		$this->addTypeRoute('image', 'img');
		$this->basePaths['route'] = $routeBase;
		$this->basePaths['private'] = $privateBase;
	}
	
	# Public interface implementation

    public function addTypeRoute($type, $folder)
    {
        $this->routes[$type] = $folder;
    }
	
	public function dispatch(DispatchedFileInterface $File, $routing = 'route')
	{
		$this->routing = $routing;
        $this->File = $File;
		$this->configureFileObject();
		try {
			$this->createFolder($this->destinationFolder());
			$destination = $this->relocate($this->File->getReceivedFile(), $this->File->getFullPath());
			$this->File->setName(pathinfo($destination, PATHINFO_BASENAME));
			$this->File->setDispatched();
			return $this->File;
		} catch (RuntimeException $e) {
			throw new RuntimeException($e->getMessage(), 1);
		}
	}
	
	/**
	 * Configure File Object
	 *
     * @param string $options
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	private function configureFileObject()
	{
		$this->File->setName(basename($this->File->getReceivedFile()));
		$this->File->setBasePath($this->baseDestinationFolder());
		$this->File->setFolder($this->typeRouting().$this->subRouting());
	}
	
    private function createFolder($folder)
    {
        if (file_exists($folder)) {
            return true;
        }
        $Folder = new Folder();
        if (!$Folder->create($folder)) {
            throw new RunTimeException(sprintf('Dispatcher: Unable to create folder %s', $folder), 1);
        }

        return true;
    }

    /**
     * Computes destination folder
     *
     * @param string $move
     *
     * @return void
     * @author Fran Iglesias
     */
    private function destinationFolder()
    {
        file_put_contents(
            LOGS.'mh-uploads.log',
            date('Y-m-d H:i > ').'[Dispatcher->destinationFolder] '.$this->baseDestinationFolder().chr(
                10
            ),
            FILE_APPEND
        );

        return $this->baseDestinationFolder().$this->typeRouting().$this->subRouting();
    }

    # Private and utility methods section
	
	/**
	 * Performs the copy or movement of the physical file
	 *
     * @param string $source
     * @param string $destination
     *
	 * @return void
	 * @author Fran Iglesias
	 */
	private function relocate($source, $destination) {
		if (!is_writable(dirname($destination))) {
			throw new RunTimeException(sprintf('Dispatcher: Unable to copy %s file in %s', $source, $destination), 1);
		}
		$destination = $this->resolveConflict($destination);
		$File = new File($source);
		if (!$File->copy($destination, true)) {
			throw new RunTimeException(sprintf('Dispatcher: Failed to copy %s file in %s', $source, $destination), 1);
		}
		if ($this->move) {
			$File->delete();
		}
		return $destination;
	}

    private function baseDestinationFolder()
    {
        if (array_key_exists($this->routing, $this->basePaths)) {
            return $this->basePaths[$this->routing];
        }

        return $this->basePaths['route'];
    }

    /**
     * Computes subroutings
     *
     * @return void
     * @author Fran Iglesias
     */

    private function typeRouting()
    {
        $type = $this->Mime->simpleType($this->File->getReceivedFile());
        if (!isset($this->routes[$type])) {
            return $this->default.DS;
        }

        return $this->routes[$type].DS;
    }

    private function subRouting()
    {
        if (empty($this->subRoutes)) {
            return false;
        }

        return implode(DS, $this->subRoutes).DS;
    }
	
	/**
	 * Computes an alernative name to resolve conflicts
	 *
     * @param string $destination
     *
	 * @return void
	 * @author Fran Iglesias
	 */

    private function resolveConflict($destination)
	{
		if (!file_exists($destination)) {
			return $destination;
		}
		// Adds a RAND in case of conflicting names to prevent long term conflicts
		$newName = pathinfo($destination, PATHINFO_DIRNAME)
			.DS
			.pathinfo($destination, PATHINFO_FILENAME)
			.'-'.mt_rand(10, 99)
			.'.'.pathinfo($destination, PATHINFO_EXTENSION);

        return $this->resolveConflict($newName);
	}

    public function addSubRoute($folder)
    {
        $this->subRoutes[] = $folder;
    }

    public function move()
    {
        $this->move = true;

        return $this;
    }

    public function copy()
    {
        $this->move = false;

        return $this;
    }
}


?>
