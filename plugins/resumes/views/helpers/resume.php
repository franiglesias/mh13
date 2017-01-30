<?php
/**
 * ResumeHelper
 * 
 * [Short Description]
 *
 * @package resumes.milhojas
 * @version $Id$
 **/

class ResumeHelper extends AppHelper {
	
	/**
	 * An array containing the names of helpers this controller uses. The array elements should
	 * not contain the "Helper" part of the classname.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 * @access protected
	 */
	var $helpers = array('Html', 'Form', 'Ui.Media');

	public function typesMenu()
	{
		App::import('Model', 'Resumes.MeritType');
		$mt = ClassRegistry::init('MeritType');
		$types = $mt->find('all');
		if (empty($types)) {
			return false;
		}
		foreach ($types as $type) {
			$menu[] = $this->Html->link(
				$type['MeritType']['title'],
				array('plugin' => 'resumes', 'controller' => 'merits', 'action' => 'show', $type['MeritType']['id']),
				array('class' => 'mh-btn-ok')
			);
		}
		return implode(chr(10), $menu);
	}

	public function stats($stats)
	{
		App::import('Model', 'Resumes.MeritType');
		$mt = ClassRegistry::init('MeritType');
		$types = $mt->find('all');
		$rows = array();
		$headers = $this->Html->tag('th', __d('resumes', 'Category', true));
		$headers .= $this->Html->tag('th', __d('resumes', 'Merits in this category', true));
		$headers .= $this->Html->tag('th', __d('resumes', 'Add merits', true));
		$headers = $this->Html->tag('tr', $this->Html->tag('thead', $headers));
		foreach ($types as $type) {
			$title = $type['MeritType']['title'];
			$value = $stats[$type['MeritType']['alias']];
			if ($value == 0) {
				$label = __d('resumes', "You haven't any merits yet in this category. Add some.", true);
			} else {
				$label = __d('resumes', 'Add new merits in this category.', true);
			}
			$link = $this->Html->link(
				$label,
				array('plugin' => 'resumes', 'controller' => 'merits', 'action' => 'show', $type['MeritType']['id']),
				array('class' => '')
			);
			$row = $this->Html->tag('td', $title);
			$row .= $this->Html->tag('td', $value);
			$row .= $this->Html->tag('td', $link);
			$rows[] = $this->Html->tag('tr', $row);
		}
		$rows = $this->Html->tag('tbody', implode(chr(10), $rows));
		return $this->Html->tag('table', $headers.$rows);
	}

	
	public function meritLine($merit)
	{
		if (empty($merit['start']) && empty($merit['end'])) {
			$dates = '';
		} elseif (empty($merit['start']) || empty($merit['end'])) {
			$dates = $merit['start'] . $merit['end'];
		} else {
			$dates = sprintf('%s - %s', $merit['start'], $merit['end']);
			}
		if ($dates) {
			$dates = $this->Html->tag('div', $dates, array('class' => 'media-object merit-media-object'));
		}
		$body = $this->Html->tag('h3', $merit['title']);
		$body .= $this->Html->tag('p', $merit['remarks']);
		if (!empty($merit['url'])) {
			$link = $this->Html->link(
				sprintf(__d('resumes', 'Visit web: %s', true), $merit['title']),
				$merit['url']
			);
			$body .= $this->Html->tag('p', $link);
		}

		if (!empty($merit['file'])) {
			$link = $this->Media->file($merit['file']);
			$body .= $this->Html->tag('p', $link);
		}

		$body = $this->Html->tag('div', $body, array('class' => 'media-body merit-body'));
		return $this->Html->tag('div', $dates.$body, array('class' => 'media merit'));
	}
	
	
	public function dates($merit)
	{
		if (empty($merit['start']) && empty($merit['end'])) {
			$dates = '';
		} elseif (empty($merit['start']) || empty($merit['end'])) {
			$dates = $merit['start'] . $merit['end'];
		} else {
			$dates = sprintf('%s-%s', $merit['start'], $merit['end']);
		}
		return $dates;
	}
	
	public function merit($merit)
	{
		$body = $this->Html->tag('h3', $merit['title'], array('class' => 'mh-resume-merit-title'));
		$body .= $this->Html->tag('p', $merit['remarks']);
		if (!empty($merit['url'])) {
			$link = $this->Html->link(
				sprintf(__d('resumes', 'Visit web: %s', true), $merit['title']),
				$merit['url']
			);
			$body .= $this->Html->tag('p', $link);
		}
		try {
			if (!empty($merit['file'])) {
				$link = $this->Media->file($merit['file']);
				$body .= $this->Html->tag('p', $link);
			}
		} catch (Exception $e) {
			$body .= $this->Html->tag('p', sprintf('Problem with %s file.', $merit['file']));
		}

		return $this->Html->tag('div', $body, array('class' => 'mh-resumes-merit'));
	}
}