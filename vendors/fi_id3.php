<?php

App::import('vendor', 'getid3');
App::import('Lib', 'FiMime');
/**
* FiId3
* 
* Extends getID3 to extract selected info from files normalizing certain data for easier management
* 
* 
*/

class FiId3 extends getID3
{
	var $fiInfo = array(
		'size' => 0,
	    'type' => '',
	    'playtime' => 0,
	    'fullPath' => '',
		'path' => '',
		'name' => '',
	    'height' => 0,
	    'width' => 0,
	    'author' => '',
	    'description' => '',
	    'title' => '',
		);
	
	public function info($file)
	{
		if ($file[0] != DS) {
			$file = WWW_ROOT . $file;
		}
		if (!file_exists($file)) {
			return false;
		}
		$info = $this->analyze($file);
		$this->basic($info);
		$this->size($info);
		$this->tags($info);
		if(empty($this->fiInfo['title'])) {
			$name = basename($this->fiInfo['fullPath']);
			$this->fiInfo['title'] = substr($name, 0, strpos($name, '.'));
		}
		$this->fiInfo['name'] = $this->fiInfo['title'];
		$this->fiInfo['path'] = str_replace(WWW_ROOT, '', $this->fiInfo['fullPath']);
		return $this->fiInfo;
	}
	
	
	protected function basic(&$info)
	{
		$this->fiInfo['size'] = $info['filesize'];
		$mt = new FiMime();
		$this->fiInfo['type'] = $mt->type($info['filename']);
		// fallback
		if (empty($this->fiInfo['type'])) {
			$this->fiInfo['type'] = $info['mime_type'];
		}
		unset($mt);

		$this->fiInfo['fullPath'] = $info['filenamepath'];
		if (!empty($info['playtime_seconds'])) {
			$this->fiInfo['playtime'] = round($info['playtime_seconds'], 3);
		}
 	}
	
	protected function size(&$info) {
		if (!isset($info['video'])) {
			$this->fiInfo['width'] = $this->fiInfo['height'] = null;
			return;
		}
		$this->fiInfo['width'] = $info['video']['resolution_x'];
		$this->fiInfo['height'] = $info['video']['resolution_y'];
		return;
	}
	
	protected function tags(&$info) {
		if (isset($info['tags'])) {
			$type = key($info['tags']);
			$method = strtolower($type).'Tags';
			if (method_exists($this, $method)) {
				return $this->$method($info['tags']);
			}
		}
		
		if (isset($info['comments'])) {
			return $this->commentsTags($info['comments']);
		}
		
		if (isset($info['asf'])) {
			return $this->commentsTags($info['asf']['comments']);
		}
		return;
	}
	
	protected function quicktimeTags($tags)
	{
		if (empty($tags['quicktime'])) {
			return;
		}
		extract($tags['quicktime']);
		if (is_array($title)) {
			$title = array_shift($title);
		}
		$this->fiInfo['title'] = $title;
		
		if (isset($comment)) {
			if (is_array($comment)) {
				$comment = array_shift($comment);
			}
			$this->fiInfo['description'] = $comment;
		}
		if (is_array($artist)) {
			$artist = array_shift($artist);
		}
		$this->fiInfo['author'] = $artist;
	}
	
	protected function id3v2Tags($tags) {
		if (empty($tags['id3v2'])) {
			return;
		}
		extract($tags['id3v2']);
		$this->fiInfo['title'] = array_shift($title);
		$this->fiInfo['description'] = array_shift($comments);
		$this->fiInfo['author'] = array_shift($artist);
		
	}
	
	protected function commentsTags($tags) {
		if (empty($tags)) {
			return;
		}
		extract($tags);
		if (!empty($title)) {
			$this->fiInfo['title'] = array_shift($title);
		}
		if (!empty($author)) {
			$this->fiInfo['author'] = array_shift($author);
		}
		$this->fiInfo['description'] = null;
		
	}
	


	
	
}


?>