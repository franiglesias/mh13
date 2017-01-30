<?php

App::import('Helper', 'CollectionPresentationModel');

class AuthorsHelper extends CollectionPresentationModelHelper {
	
	public function toList($field)
	{
		$list = array();
		$this->rewind();
		do {
			$this->next();
			$list[] = $this->Single->value($field);
		} while ($this->hasNext());
		return implode(', ', $list);
	}
	
	public function toRss()
	{
		$list = array();
		$this->rewind();
		do {
			$this->next();
			$list[] = sprintf('%s (%s)', $this->Single->value('email'), $this->Single->value('realname'));
		} while ($this->hasNext());
		return implode(', ', $list);
	}
}