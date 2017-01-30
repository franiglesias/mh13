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
class AggregatorShell extends Shell
{
	var $uses = array('Aggregator.Feed', 'Aggregator.Entry');
	var $datasource = 'default';
	
	public function main() {
		$this->help();
	}
	
	public function refresh() {
		$feeds = $this->Feed->find('all', array(
			'fields' => array('id', 'feed'), 
			'conditions' => array('approved' => true)
			)
		);
		if (!$feeds) {
			return false;
		}
		$counter = $success = $fail = 0;
		foreach ($feeds as $feed) {
			$this->out('Processing... '.$feed['Feed']['feed'].' ... ', 0);
			$this->Feed->id = $feed['Feed']['id'];
			$counter++;
			if (!$this->Feed->reload()) {
				$this->Feed->saveField('error', true);
				$this->out('Error!');
				$fail++;
				continue;
			}
			$this->Feed->saveField('error', false);
			$this->out('Ready!');
			$success++;
		}
		$this->hr();
		clearCache('element_plugin_cache_aggregatorentries_last', 'views', false);
		$this->out(sprintf('%s feeds processed. %s succeded. %s failed.', $counter, $success, $fail));
		$this->log(sprintf('%s feeds processed. %s succeded. %s failed.', $counter, $success, $fail), 'aggregator');
		
		$this->Entry->deleteOutdated();
		$this->log('Deleting outdated entries', 'aggregator');
		return true;
	}
	
	public function help() {
		$this->out('Aggregator Help');
		$this->hr();
		$this->out('Refresh the entries for all the feeds in the database',2);
		$this->out('Usage:   cake aggregator refresh',2);
	}
	
}


?>
