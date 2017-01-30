<?php

class Upload {
	
	private $id;
	private $name;
	private $description;
	private $author;
	private $url;

	private $size;
	private $type;

	private $path;
	private $fullpath;

	private $model;
	private $foreign_key;
	
	public function __construct()
	{
	}
	
	static function createFromCakeModel($data)
	{
		if (self::isImage($data)) {
			$upload = new Image();
		} else {
			$upload = new self();
		}
		$upload->loadFromDataArray($data);
		return $upload;
	}
	
	protected function loadFromDataArray($data)
	{
		foreach ($data['Upload'] as $key => $value) {
			$this->$key = $value;
		}
	}
	
	static private function isImage($data)
	{
		if (strpos($data['Upload']['type'], 'image') !== false) {
			return true;
		}
		return false;
	}
	
	public function getData()
	{
		$data = array(
			'Upload' => array(
				'id' => $this->id,
				'name' => $this->name,
				'description' => $this->description,
				'size' => $this->size,
				'type' => $this->type,
				'path' => $this->path,
				'fullpath' => $this->fullpath,
				'model' => $this->model,
				'foreign_key' => $this->foreign_key,
				'author' => $this->author,
				'url' => $this->url
			)
		);
		return $data;
	}
	
}

class Image extends Upload {
	private $width;
	private $height;
	
}
?>