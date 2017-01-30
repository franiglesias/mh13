<?php
	$options = array(
		'columns' => array(
			'Student.fullname' => array(
				'label' => __d('cantine', 'Student', true)
			),
			'Section.title' => array(
				'label' => __d('cantine', 'Section', true)
			),
			'CantineRegular.month' => array(
				'label' => __d('cantine', 'Month', true),
				'type' => 'switch',
				'switch' => $months
			), 
			'CantineRegular.days_of_week' => array(
				'label' => __d('cantine', 'Week days', true),
				'type' => 'days',
				'mode' => 'labor compact'
				), 
			'Student.extra1' => array(
				'label' => __d('cantine', 'Extra 1', true),
				'type' => 'days',
				'mode' => 'labor compact'
			),
			'CantineRegular.total_days' => array(
				'label' => __d('cantine', 'Total', true)
			),
			'Student.remarks' => array(
				'label' => __d('cantine', 'Remarks', true)
			)
		)
	);

	$this->Table->simplify($cantineRegulars, $options);
	$line = $this->Table->csvHeaders(); 
	$this->Csv->addRow($line);
	$lines = $this->Table->csvData();
	foreach ($lines as $row) {
		$this->Csv->addRow($row);
	}
	echo $this->Csv->render($fileName);
?>