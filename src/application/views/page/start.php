<?php if($user = $this->usermodel->get_user()):?>
Välkommen <?php echo $user->user_firstname; ?> <?php echo $user->user_surname; ?> till <?php echo base_url(); ?>.<br />
<?php echo anchor('user/logout', 'Logga Ut'); ?>
<?php endif;?>