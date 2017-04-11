<?php
class Sindex extends SearchableAppModel {
	var $name = 'Sindex';
	
/**
 * Looks for the search terms into de Sindex model and returns an array with the id as keys and the relevance index
 *
 * @param string $term
 *
 * @return array ids as keys, relevance as value
 * @status deprecated ????
 */	
	public function search($term)
	{
		$fields = array(
			'Sindex.fk',
			'MATCH (Sindex.content) AGAINST (\'' . $term . '\') AS score'
		);
		$this->log(sprintf('Search terms: ', $term), 'search');
		$conditions['MATCH(Sindex.content) AGAINST(? IN BOOLEAN MODE)'] = $term;
		$result = $this->find('all', compact('fields', 'conditions'));
		$result = Set::combine($result, '/Sindex/fk', '/0/score');
		return $result;
	}



}

?>
