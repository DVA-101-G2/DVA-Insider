Hej <?php echo $user_firstname; ?> <?php echo $user_surname; ?><br />
Du har registrerat dig på <?php echo anchor(); ?> och detta är en verifikation på att du äger denna e-postadressen.<br />
Klicka på den här länken för att slutföra registreringen: <?php echo anchor('user/email_authentication/'.$user_id.'/'.$user_email_authentication_key); ?><br />
Om du inte har bett om att bli registrerad på <?php echo anchor(); ?> skicka ett email till ... .