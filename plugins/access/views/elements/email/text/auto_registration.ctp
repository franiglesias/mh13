Estimada/o <?php echo $user['realname'] ?>:

Por favor, visita el siguiente enlace para completar tu proceso de registro.

<?php echo Router::url(array('action' => 'confirm', $ticket), true); ?> 

--------------

Dear <?php echo $user['realname'] ?>:

Please, visit the following link to complete your registration process.

<?php echo Router::url(array('action' => 'confirm', $ticket), true); ?> 
