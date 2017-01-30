<?php
/**
 *  aggregator
 *
 *  Created by  on 2010-07-09.
 *  Copyright (c) 2010 Fran Iglesias. All rights reserved.
 **/

/**
* 
*/

App::import('Core', 'HttpSocket');
App::import('Vendor', 'AppShell');

class ContentsShell extends AppShell
{
	var $uses = array('Contents.Item', 'Tags.Tag');
	var $datasource = 'default';

/**
 * En caso necesario cambiar también en el patrón de _getCirculares
 *
 * @var string
 */
	var $circularesBaseUrl = 'www2.miralba.org/circulares/circulares';

	public function main() {
		$this->help();
	}
	
	public function load() {
		$path =  APP.'webroot/files/';
		$channel_id = '4d58f863-cf1c-409a-926d-0259c695dee1';
		$this->Item->scanFolder($path, $channel_id);
		
	}
	
	public function help() {
		$this->out('Contents Help');
		$this->hr();
		$this->out('Create Items from files in folder',2);
		$this->out('Usage:   cake contents load',2);
		
	}
	
	public function circulares()
	{
		$channel_id = '50a5ff05-38b8-4f12-846d-1b3cac100002';
		$user_id = '4c7ccac3-6124-4d68-9cbf-28f0c695dee1';
		$source = 'http://'.$this->circularesBaseUrl.'/index';
		$destPath = '/Volumes/data/Web/miralba.org/files'.DS;
		$circulares = $this->_getCirculares($source);
		foreach ($circulares as $circular) {
			$guid = $this->_formatGuid($circular[1], $circular[4]);
			$file = $destPath . $guid . '.pdf';
			if (file_exists($file)) {
				continue;
			}
			list($day, $month, $year) = explode('-', $circular[1]);
			$data['Item']['pubDate'] = sprintf('%04s-%02s-%02s 00:00:00', $year, $month, $day);
			$data['Item']['status'] = 2;
			$data['Item']['title'] = sprintf('Circular %s: %s', $circular[4], $circular[5]);
			$data['Item']['content'] = sprintf('<p><strong>Destinatarios:</strong> %s</p>', $circular['3']);
			$data['Item']['channel_id'] = $channel_id;
			
			$data['Enclosure']['model'] = 'Item';
			$data['Enclosure']['name'] = sprintf('Circular %s-%s-%s', $day, $month, $year);
			$data['Enclosure']['enclosure'] = 1;
			$data['Enclosure']['fullpath'] = $file;
			$data['Enclosure']['path'] = 'files' . DS . $guid . '.pdf';
			$data['Enclosure']['type'] = 'application/pdf';
			
			$this->_getPDF($circular[4], $file);
			$data['Enclosure']['size'] = filesize($file);
			
			$this->Item->create();
			$this->Item->setDefaults($channel_id);
			$this->Item->saveAll($data);
			$this->Item->bindUser($user_id, 'author', $this->Item->id);
		}
		
	}
	
	public function _getCirculares($url)
	{
		$pattern = '/<td class="fecha">([^<]+)<\/td>\s+<td class="tipo">([^<]+)<\/td>\s+<td class="destinatarios">([^<]+)<\/td>\s+<td class="titulo"><a href="\/circulares\/circulares\/ver\/(\d+)">([^<]+)<\/a>\s+<\/td>/';
		$Socket = new HttpSocket();
		$page = $Socket->get($url);
		if ($page) {
			$this->out('OK: '.$url);
		} else {
			$this->out('Failed: '.$url);
		}
		unset($Socket);
		$matches = array();
		preg_match_all($pattern, $page, $matches, PREG_SET_ORDER);
		$this->out('Found: '.count($matches));
		return $matches;
	}
	
	public function _formatGuid($date, $id)
	{
		list($day, $month, $year) = explode('-', $date);
		$guid = sprintf('circular-%04s-%02s-%02s-%06s', $year, $month, $day, $id);
		return $guid;
	}
	
	public function _getPDF($id, $dest)
	{
		$url = 'http://'.$this->circularesBaseUrl.'/ver/%s.pdf';
		$url = sprintf($url, $id);
		$Socket = new HttpSocket();
		$file = $Socket->get($url);
		unset($Socket);
		$F = new File($dest);
		$F->open('w');
		$F->write($file);
		$F->close();
		unset($F);
	}

	
}


?>
