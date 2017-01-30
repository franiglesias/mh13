<p>Estimada/o <strong><?php echo $user['realname'] ?></strong>:</p>
<p>Por favor, visita el siguiente enlace para completar tu proceso de registro.</p>
<p><?php echo $this->Html->link('Confirmar mi registro', Router::url(array('action' => 'confirm', $ticket), true)); ?> </p>

<hr />

<p>Dear <strong><?php echo $user['realname'] ?></strong>:</p>
<p>Please, visit the following link to complete your registration process.</p>
<p><?php echo $this->Html->link('Confirm my registration',Router::url(array('action' => 'confirm', $ticket), true)); ?> </p>
