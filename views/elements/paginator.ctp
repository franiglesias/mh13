<?php 
	$params = $this->Paginator->params();
	if (!isset($params['pageCount']) || $params['pageCount'] <= 1) {
		return;
	}
?>
<div class="mh-paginator">
	<ul class="pagination">
	<?php echo $this->Paginator->prev('<<', array('class' => 'arrow', 'tag' => 'li'), null, array('tag' => 'li', 'class'=>'arrow unavailable'));?>
	<?php echo $this->Paginator->numbers(array('first' => 0, 'last' => 0, 'modulus' => 5, 'separator' => '', 'tag' => 'li'));?>
	<?php echo $this->Paginator->prev('>>', array('class' => 'arrow', 'tag' => 'li'), null, array('tag' => 'li', 'class'=>'arrow unavailable'));?>
	</ul>
	<span class="counter"><?php echo $this->Paginator->counter(array('format' => __(PAGINATOR_SHORT, true)));?></span>
</div>

