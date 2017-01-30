<?php

/**
* CantineHelper
*/
class CantineHelper extends AppHelper
{
	
	var $helpers = array('Html');

/**
 * Builds data for one day
 *
 * @param string $menu 
 * @return void
 * @author Fran Iglesias
 */
	public function day($menu)
	{
		$text = $menu[0]['CantineWeekMenu']['CantineDayMenu'][$menu['weekDay']-1]['menu'];
		if (!empty($menu['Remark'][$menu['date']])) {
			$text = $menu['Remark'][$menu['date']];
		}
		return $this->_addPTags($text);
	}
	
	public function facts($menu)
	{
		if (empty($menu['CantineWeekMenu'])) {
			return false;
		}
		return $this->_buildNutritionFacts($menu['CantineWeekMenu']);
	}


/**
 * Builds a menu table for a range of dates
 *
 * @param array $data the menu data as returned by CantineMenuDate->find('range')
 * @param array $range array of time
 * @return html
 */
	public function table($data, $range)
	{
		$code = '';
		$remarks = '';
		if (!empty($data['Remark'])) {
			$remarks = $data['Remark'];
		}
		unset($data['Remark']);
		foreach ($data as $week => $menu) {
			$row = '';
			$countDays = 0;
			$startDate = strtotime($menu['CantineMenuDate']['start']);
			
			for ($day=1; $day <= 5; $day++) { 
				$cellDate = strtotime('+ '.$countDays.' DAY', $startDate);
				$countDays++;
				
				if (($cellDate < $range['start']) || ($cellDate > $range['end'])) {
					$row .= "<td>&nbsp;</td>";
					continue;
				}

				$displayDate =  date('j/m', $cellDate);
				$cell = $this->Html->tag('p', $displayDate, array('class' => 'mh-cantine-day')) ;

				$date = date('Y-m-d', $cellDate);
				if (!empty($remarks[$date])) {
					$cell .= $this->_addPTags($remarks[$date]);
				} else {
					$cell .= $this->_addPTags($menu['CantineWeekMenu']['CantineDayMenu'][$day-1]['menu']);
				}

				$class = "mh-cantine-cell";
				
				if (!defined('CAKE_TEST_EXECUTION') && date('Y-m-d') == $date) {
					$class .= ' mh-today';
				}

				$row .= $this->Html->tag('td', $cell, array('class' => $class));
			}
			$row .= $this->Html->tag('td', $this->_buildNutritionFacts($menu['CantineWeekMenu']), array(
				'class' => 'mh-cantine-cell mh-cantine-cell-facts'
				));
			$code .= $this->Html->tag('tr', $row);
		}
		$code = $this->Html->tag('tbody', $code);
		return $this->Html->tag('table', $this->_buildWeekHeader().$code, array('class' => 'mh-cantine-table'));
	}
	
	public function _addPTags($text)
	{
		return preg_replace('/^.*$/m', "<p>$0</p>", $text);
	}

/**
 * Builds the week header for the menu table, including a column for nutrition facts
 *
 * @return html
 */	
	public function _buildWeekHeader()
	{
		$wd = array(
			__('monday', true),
			__('tuesday', true),
			__('wednesday', true),
			__('thursday', true),
			__('friday', true),
		);
		$header = '';
		foreach ($wd as $dayName) {
			$header .= $this->Html->tag('th', $dayName, array('class' => 'mh-cantine-cell'));
		}
		$header .= $this->Html->tag('th', __d('cantine', 'Nutrition', true), array('class' => 'mh-cantine-cell mh-cantine-cell-facts'));
		return $this->Html->tag('thead', $this->Html->tag('tr', $header));
	}

/**
 * BUilds nutrition facts data from an array, excludes all unneeded keys
 *
 * @param array $facts 
 * @return html
 */	
	public function _buildNutritionFacts($facts)
	{
		$keys = array(
			'calories' => true,
			'glucides' => true,
			'lipids' => true,
			'proteines' => true
		);
		$labels = array(
			'calories' => __d('cantine', 'calories', true),
			'glucides' => __d('cantine', 'glucides', true),
			'lipids' => __d('cantine', 'lipids', true),
			'proteines' => __d('cantine', 'proteines', true)
		);
		$facts = array_intersect_key($facts, $keys);
		
		$code = '';
		foreach ($facts as $fact => $value) {
			$line = $this->Html->tag('strong', $labels[$fact]);
			$line .= ':&nbsp;'.$value;
			$code .= $this->Html->tag('p', $line);
		}
		return $code;
	}
}


?>