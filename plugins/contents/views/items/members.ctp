<?php
	$options = array(
		Item::COAUTHOR => 'Escribir y leer',
		Item::AUTHOR => 'Escribir, leer y eliminar',
	);
?>
<?php echo $this->XHtml->ajaxLoading('mh-permissions-busy-indicator'); ?>
<label><?php __d('contents', 'Members') ?></label>
<table>
	<thead>
		<tr>
			<th><?php __d('contents', 'User'); ?></th>
			<th><?php __d('contents', 'Access'); ?></th>
			<th class="actions"><?php __d('contents', 'Action'); ?></th>
		</tr>
	</thead>
<tbody>	
<?php foreach ($members as $member): ?>
	<tr>
		<td><?php echo $member['User']['realname'].' ('.$member['User']['username'].'):';  ?></td>
		<td><?php echo $options[$member['Owner']['access']] ?></td>
		<td class="actions"><?php echo $this->Html->link(
			__d('contents', 'unbind', true),
			'#',
			array(
				'class' => 'mh-unbind mh-btn-action',
				'id' => 'Unbind_User_'.$member['User']['id'],
				'mh-owner-model' => 'User',
				'mh-owner-id' => $member['User']['id'],
				'mh-object-model' => 'Item',
				'mh-object-id' => $id,
				'mh-url' => '/contents/items/members/'.$id,
				'mh-update' => '#mh-item-members'
				)
			);
		
		?></td>
	</tr>
<?php endforeach ?>
<?php if (!empty($notMembers)): ?>
<?php
	$defaultMember = null;
	if (count($notMembers) == 1) {
		$defaultMember = key($notMembers);
	}
	?>
		<tr>
			<td><?php echo $this->FForm->select('Item.notMember', array(
				'options' => $notMembers,
				'value' => $defaultMember,
				'div' => false,
				'empty' => __d('contents', 'Select a user', true)
			)); ?></td>
			<td><?php echo $this->FForm->select('Item.role', array(
				'options' => $options,
				'value' => Item::COAUTHOR,
				'div' => false,
				'empty' => __d('contents', 'Select a role', true)
			)); ?></td>
			<td><?php echo $this->Form->button('bind', array(
				'type' => 'button', 
				'id' => 'bind', 
				'class' => 'mh-bind button',
				'mh-owner-model' => 'User',
				'mh-owner-id' => '#ItemNotMember',
				'mh-object-model' => 'Item',
				'mh-object-id' => $id,
				'mh-access' => '#ItemRole',
				'mh-url' => '/contents/items/members/'.$id,
				'mh-update' => '#mh-item-members'
			)); ?></td>
		</tr>
		
	</tbody>
</table>
<?php else: ?>
	</tbody>
	</table>
	<p><?php __d('contents', 'All available users are autors of this Item'); ?></p>	 
<?php endif; ?>

