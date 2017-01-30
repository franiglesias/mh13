<aside class="mh-page-extras" id="mh-multimedia">
	<div class="mh-page-extras-container">
	<?php if (!empty($item['Enclosure']['id']) || !empty($item['Multimedia'])): ?>
		<h2 class="mh-page-extras-title"><?php __d('contents', 'Multimedia'); ?></h2>
			<?php if (!empty($item['Enclosure']['id'])): ?>
				<?php $item['Multimedia'][] = $item['Enclosure']; ?>
			<?php endif ?>
			<?php if (!empty($item['Multimedia'])) {
				foreach ($item['Multimedia'] as $multimedia) {
					echo $this->Widget->put('video', $multimedia);
				}
			} ?>
	<?php endif ?>
	</div>
</aside>