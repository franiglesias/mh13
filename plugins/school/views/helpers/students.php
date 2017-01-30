<?php
/**
 * StudentHelper
 * 
 * [Short Description]
 *
 * @package school.mh13
 * @author Fran Iglesias
 * @version $Id$
 * @copyright Fran Iglesias
 **/
App::import('Helper', 'CollectionPresentationModel');

class StudentsHelper extends CollectionPresentationModelHelper {

	var $helpers = array('Html', 'Form', 'Paginator', 'Ui.Table');
	var $model = 'Student';
	var $var = 'students';

	public function overviewTable()
	{
		$options = array(
			'columns' => array(
				'Student.fullname' => array(
					'label' => __d('school', 'Student', true),
					'attr' => array('class' => 'cell-long')
				),
				'CantineRegular.days_of_week' => array(
					'type' => 'days',
					'empty' => '•',
					'mode' => 'labor compact',
					'label' => __d('school', 'Cantine', true),
					'attr' => array('classr' => 'cell-medium')
				),
				'Student.extra1' => array(
					'type' => 'days',
					'empty' => '•',
					'mode' => 'labor compact',
					'label' => __d('school', 'Extra1', true),
					'attr' => array('class' => 'cell-medium')
				), 
				'Student.extra2' => array(
					'type' => 'boolean',
					'label' => __d('school', 'Extra2', true),
					'attr' => array('class' => 'cell-short')
				)
				
			),
			'actions' => null
		);
		return $this->Table->render($this->DataProvider->dataSet(), $options);
	}
	
	public function adminTable()
	{
		$options = array(
			'columns' => array(
				// 'id', 
				'fullname' => array(
					'label' => __d('school', 'Student', true),
					'attr' => array('class' => 'cell-long')
				), 
				'Section.title' => array(
					'label' => __d('school', 'Section title', true),
					'attr' => array('class' => 'cell-medium')
				), 
				'extra1' => array(
					'type' => 'days',
					'empty' => '--',
					'mode' => 'labor compact',
					'label' => __d('school', 'Extra1', true),
					'attr' => array('class' => 'cell-medium')
				), 
				'extra2' => array(
					'type' => 'boolean',
					'label' => __d('school', 'Extra2', true),
					'attr' => array('class' => 'cell-short')
				)
			),
			'actions' => array(
				'edit' => array('label' => __('Edit', true)),
				'delete' => array(
					'label' => __('Delete', true), 
					'confirm' => __('Are you sure?', true)
					)
				),
			'table' => array('class' => 'admin-table')
			);
		return $this->Table->render($this->DataProvider->dataSet(), $options);

	}
}