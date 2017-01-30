<?php
// Uses a Model key to indentify its data
interface AttachedDataProvider 
{
	public function useModel($model);
	public function getModel();
	public function hasModel();
	
}

?>