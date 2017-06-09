<?php 
if (!$items) {
	echo '<p>Nothing found</p>.';
	return;
}
$title = sprintf(__d('contents', 'Search results for term <strong>%s</strong>', true), $term);
$this->Items->bind($items);
$this->Items->attach($this->Item);
$B = LayoutFactory::get('List', $this->Items);
echo $B->withTitle($this->Page->title($title))
		->usingLayout('items/layouts/feed')
		->usingTemplate('items/templates/search')
		->withFooter('')
		->render();
?>
