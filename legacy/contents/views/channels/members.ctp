<?php echo $this->XHtml->ajaxLoading('mh-permissions-busy-indicator'); ?>
<label><?php __d('contents', 'Members') ?></label>
<table>
	<thead>
	<tr>
		<th><?php echo __d('contents', 'User', true); ?></th>
		<th><?php echo __d('contents', 'Role', true); ?></th>
		<th class="actions"><?php echo __d('contents', 'Action', true); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ((array)$members as $member): ?>
		<tr>
			<td><?php echo $member['User']['realname'].' ('.$member['User']['username'].'):';  ?></td>
			<td><?php echo $this->FForm->select('access', array(
				'options' => $roles,
				'value' => $member['Owner']['access'],
				'div' => false,
				'label' => false,
				'empty' => false, 
				'id' => 'Role_User_'.$member['User']['id'],
				'class' => 'mh-rebind',
				'mh-owner-model' => 'User',
				'mh-owner-id' => $member['User']['id'],
				'mh-object-model' => 'Channel',
				'mh-object-id' => $id,
				'mh-url' => '/contents/channels/members/'.$id,
				'mh-update' => '#mh-channel-members'
			)); ?>
				
			</td>
			<td class="actions"><?php echo $this->Html->link(
				__d('contents', 'unbind', true),
				'#',
				array(
					'class' => 'mh-unbind mh-btn-action',
					'id' => 'Unbind_User_'.$member['User']['id'],
					'mh-owner-model' => 'User',
					'mh-owner-id' => $member['User']['id'],
					'mh-object-model' => 'Channel',
					'mh-object-id' => $id,
					'mh-url' => '/contents/channels/members/'.$id,
					'mh-update' => '#mh-channel-members'
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
			<td>
				<?php echo $this->FForm->autocomplete('Channel.notMember', array(
				'url' => array('plugin' => 'contents', 'controllers' => 'channels', 'action' => 'notmembers', $id)
				)); ?>
				<?php 
				// echo $this->FForm->select('Channel.notMember', array(
				// 'options' => $notMembers,
				// 'value' => $defaultMember,
				// 'div' => false,
				// 'empty' => __d('contents', 'Select a user', true)
				// ));
				?></td>
			
			<td><?php echo $this->FForm->select('Channel.role', array(
				'options' => $roles,
				'value' => Channel::CONTRIBUTOR,
				'div' => false,
				'empty' => __d('contents', 'Select a role', true)
			)); ?></td>
			<td><?php echo $this->Form->button('bind', array(
				'type' => 'button', 
				'id' => 'bind', 
				'class' => 'mh-bind button',
				'mh-owner-model' => 'User',
				'mh-owner-id' => '#ChannelNotMember',
				'mh-object-model' => 'Channel',
				'mh-object-id' => $id,
				'mh-access' => '#ChannelRole',
				'mh-url' => '/contents/channels/members/'.$id,
				'mh-update' => '#mh-channel-members'
			)); ?></td>
		</tr>
	</tbody>
</table>
	  	 
<?php else: ?>
	</table>
	<p><?php __d('contents', 'All available users are members of this Channel'); ?></p>	 
<?php endif; ?>

