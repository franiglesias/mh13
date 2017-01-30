<?php

App::import('Lib', 'fi_layout/FiLayout');

/**
* 
*/
class MagazineLayout extends AbstractLayout
{
	public function order()
	{
		$maxColumns = 4;
		$ratio = 12 / $maxColumns;
		$rows = array();
		$magazine = array();
		$rows[0] = $maxColumns;
		$this->CollectionPresentationModel->rewind();
		// $this->CollectionPresentationModel->Single->source($this->CollectionPresentationModel->DataProvider->current());
		// Traverse the items list
		while ($this->CollectionPresentationModel->hasNext()) {
			$this->CollectionPresentationModel->next();
			// Calculate columns for current item, and append the data
			$columns = rand(1,4);//$this->CollectionPresentationModel->Single->columns();
			$ready = false;
			do {
				// Traverse existing rows
				for ($c=0; $c < count($rows); $c++) { 
					// If there is enough free space annotate the item index in the magazine matrix
					if ($rows[$c] >= $columns) {
						$magazine[$c][] = $this->CollectionPresentationModel->pointer();
						// Remove free space
						$rows[$c] = $rows[$c] - $columns;
						$ready = true;
						continue 2;
					}
				}
				if (!$ready) {
					// We need a new row
					$rows[] = $maxColumns;
				}
			} while (!$ready);
		}
		$lines = array();
		foreach ($magazine as $row => $items) {
			foreach ($items as $item) {
				$lines[] = $item;
			}
		}
		
		return $lines;
	}
	
}

?>