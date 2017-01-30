<?php

interface FiMessage {
	public function setRecipient($recipient);
	public function getRecipient();
	public function setSender($sender);
	public function getSender();
	public function setSubject($subject = false);
	public function getSubject();
	public function setContent($content = false);
	public function getContent();
	public function attach($attachement);
}
?>