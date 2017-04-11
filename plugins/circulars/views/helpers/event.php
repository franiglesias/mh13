<?php


App::import('Helper', 'MultilingualPresentationModel');

class EventHelper extends MultilingualPresentationModelHelper implements AutoLinkable

{
	var $helpers = array('Html', 'Form');
	var $var = 'event';
	
	var $templates = array(
		'full' => array(
			'all_day' => ':startDate. :title',
			'all_period' => ':startDate-:endDate. :title',
			'start_day' => ':startDate :startTime. :title',
			'start_period' => ':startDate-:endDate :startTime. :title',
			'limited_day' => ':startDate :startTime-:endTime. :title',
			'limited_period' => ':startDate-:endDate :startTime-:endTime. :title',
			),
		'day' => array(
			'all_day' => ':title',
			'all_period' => ':title',
			'start_day' => ':startTime. :title',
			'start_period' => ':startTime. :title',
			'limited_day' => ':startTime-:endTime. :title',
			'limited_period' => ':title',
			),
		'continuous' => array(
			// 'all_day' => ':startDate. :title',
			// 'all_period' => ':startDate-:endDate. :title',
			// 'start_day' => ':startDate :startTime. :title',
			// 'start_period' => ':startDate-:endDate :startTime. :title',
			// 'limited_day' => ':startDate :startTime-:endTime. :title',
			'limited_period' => ':startDate-:endDate. :title',
			),
		);
	
	public function selfUrl()
	{
		return array(
			'plugin' => 'circulars',
			'controller' => 'events',
			'action' => 'view',
			$this->value('id'));
	}

	public function combined($mode = 'full') {
		$template = $this->value('subType').'_'.$this->value('type');
		if ($this->value('continuous')) {
			$mode = 'continuous';
		}
		$event = array(
			'startDate' => $this->format('startDate', array('date' => null, 'empty' => false)),
			'endDate' => $this->format('endDate', array('date' => null, 'empty' => false)),
			'startTime' => $this->format('startTime', array('time' => null, 'empty' => false)),
			'endTime' => $this->format('endTime', array('time' => null, 'empty' => false)),
			'title' => $this->value('title')
		);

        return CakeString::insert($this->templates[$mode][$template], $event);
	}
	
	public function calendar($field, $timeField = false)
	{
		$time = '';
		$month = $this->Html->para('month', $this->format($field, 'monthYear'));
		$dayName = $this->Html->para('dayname', $this->format($field, 'dayName'));
		$day = $this->Html->para('day', $this->format($field, 'dayNumber'));

		if ($timeField) {
			$time = $this->Html->para('time', $this->format($timeField, 'time'));
		}
		$code = $this->Html->div('mh-calendar-block', $month.$day.$dayName.$time);
		return $code;
		
	}
	
	public function trip()
	{
		$template = __d('circulars', '%s: %s at %s', true);
		$departure = sprintf(
			$template,
			__d('circulars', 'Departure', true),
			$this->format('startDate', 'date'),
			$this->format('startTime', 'time')
		);
		$return = sprintf(
			$template,
			__d('circulars', 'Return', true),
			$this->format('endDate', 'date'),
			$this->format('endTime', 'time')
		);
		return sprintf('%s. %s.', $departure, $return);
	}
	
	
	public function fieldtrip()
	{
		$template = __d('circulars', '%s: %s at %s', true);
		$departure = sprintf(
			$template,
			__d('circulars', 'Departure', true),
			$this->format('startDate', 'date'),
			$this->format('startTime', 'time')
		);
		$return = sprintf(
			__d('circulars', '%s at %s', true),
			__d('circulars', 'Return', true),
			$this->format('endTime', 'time')
		);
		return sprintf('%s. %s.', $departure, $return);
	}
	
	public function meeting()
	{
		$template = __d('circulars', '%s: %s at %s', true);
		return sprintf(
			$template,
			__d('circulars', 'Meeting start', true),
			$this->format('startDate', 'date'),
			$this->format('startTime', 'time')
		);
	}
	
}
?>
