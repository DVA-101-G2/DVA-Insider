<?php echo validation_errors(); ?><br />
<?php echo form_open('user/register'); ?>
E-postadress: <input type="text" name="email" /><br />
Lösenord: <input type="password" name="password" /><br />
Lösenord igen: <input type="password" name="passconf" /><br />
Förnamn: <input type="text" name="firstname" /><br />
Efternamn: <input type="text" name="surname" /><br />
<input type="submit" />
</form>