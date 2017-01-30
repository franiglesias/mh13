<?php

App::import('Lib', 'fi_messenger/FiMessage');

abstract class AbstractMessage implements FiMessage
{
	private $sender;
	private $recipient;
	private $subject;
	private $content;
	private $attachments;
	
	public function setSender($sender)
	{
		$this->sender = $sender;
	}
	
	public function getSender()
	{
		return $this->sender;
	}
	
	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
	}
	
	public function getRecipient()
	{
		return $this->recipient;
	}
	
	public function setSubject($subject = false)
	{
		$this->subject = $subject;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function setContent($content = false)
	{
		$this->content = $content;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	public function attach($attachement) {
		
	}
	
	
	
}

?>