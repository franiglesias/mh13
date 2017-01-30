<?php 
	echo $this->element('items/edit_scripts', array('plugin' => 'contents')); 
	echo $this->Html->script('/ui/js/theme_layout', array('inline' => false));
	
?>

<section id="sites-edit" class="mh-admin-panel">
	<header class="mh-admin-panel-header mh-admin-contents">
		<h1 class="heading mh-admin-panel-heading">
		<?php 
			echo $this->Backend->editHeading($this->data, 'Site', 'contents', $this->Form->value('Site.title'));
		?>
		</h1>
	</header>
	<div class="mh-admin-panel-body">
		<dl class="tabs" data-tab>
			<dd><a href="#tabs-1"><?php __d('contents', 'Definition'); ?></a></dd>
			<dd><a href="#tabs-2"><?php __d('contents', 'Associated Channels'); ?></a></dd>
		</dl>
		
		<?php echo $this->Form->create('Site');?>
		<div class="tabs-content">
			<div class="content active" id="tabs-1">
				<fieldset>
					<legend><?php __d('contents', 'Site Definition'); ?></legend>
				<?php if ($this->data) {echo $this->Form->input('id');} ?>
				<div class="row">
				<?php
					echo $this->FForm->input('title', array(
						'label' => __d('contents', 'Title', true),
						'div' => 'medium-4 columns',
						'help' => __d('contents', 'The title of the Site.', true)
					));
					echo $this->FForm->input('key', array(
						'label' => __d('contents', 'Key', true),
						'div' => 'medium-4 columns end',
						'help' => __d('contents', 'The key of the Site.', true)
					));
					
				?>
				</div>
				<div class="row">
				<?php
					echo $this->FForm->input('description', array(
						'label' => __d('contents', 'Description', true),
						'type' => 'textarea',
						'class' => 'ckeditor', 
						'rows' => 5,
						'help' => __d('contents', 'A brief description of the site.', true)
						));
				?>
				</div>

				<div class="row">
				<?php
					$url = Router::url(array('controller' => 'channels', 'action' => 'layouts'));
					echo $this->FForm->select('theme', array(
						'label' => __d('contents', 'Theme', true),
						'options' => $themes,
						'empty' => __d('contents', 'Default theme', true),
						'help' => __d('contents', 'Appearance theme.', true),
						'url' => $url,
						'update' => '#divSiteLayout',
						'id' => 'ThemeSelector',
						'div' => 'medium-4 columns'
						));
					//echo $this->XHtml->ajaxLoading();
					echo $this->FForm->select('layout', array(
						'label' => __d('contents', 'Layout', true),
						'options' => $layouts,
						'empty' => __d('contents', '-- Select a layout --', true),
						'help' => __d('contents', 'Layout for Site\'s main page.', true),
						'div' => array('class' => 'medium-4 columns end'),
						'before' => $this->XHtml->ajaxLoading()
						));
				?>
				</div>
				</fieldset>
			</div>
			<div class="content" id="tabs-2">
				<fieldset>
					<legend><?php __d('contents', 'Associated Channels (click to edit)'); ?></legend>
					
					<?php
					echo $this->FForm->checkboxes('Channel', array(
						'options' => $channels,
						'label' => __d('contents', 'Channels aggregated by this site', true)
					));
					?>
				</fieldset>
			</div>
		</div>
		<?php echo $this->FForm->end(); ?>
	</div>
</section>
