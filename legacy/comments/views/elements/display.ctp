<?php
if (!isset($commentsList)) {
	$commentsList = array();
}
	$total = count($commentsList);
?>
<?php if ($commentsList): ?>
	<div class="mh-comments-metadata">
		<p>
			<span class="mh-comments-count"><?php printf(__dn('comments', 'Only %d comment for now', '%d Comments till now', $total, true), $total); ?></span>
			<?php if ($mode > COMMENTS_CLOSED): ?>
				<span class="mh-comments-form-link"><?php echo $this->Html->link(
					__d('comments', 'Write a comment', true),
					'#mh-comment-form',
					array('class' => 'mh-button')
					) ?></span>
			<?php endif ?>
			</p>
		
	</div>
	<?php foreach ($commentsList as $comment): ?>
		<div class="media mh-comment">
			<div class="media-object mh-comment-metadata">
				<p class="mh-comment-author"><?php echo $comment['Comment']['name']; ?></p>
				<p class="mh-comment-date"><?php echo $comment['Comment']['created']; ?></p>
			</div>
			<div class="media-body mh-comment-body"><?php echo $comment['Comment']['comment']; ?></div>
		</div>
	<?php endforeach ?>

<?php else: ?>
	<div><p><?php __d('comments', 'Nobody has commented yet.'); ?></p></div>
<?php endif ?>