<?php echo form_open('user/register'); ?>
<label for="email">E-postadress</label> <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><div class="error">&nbsp;<?php echo form_error('email'); ?></div>
<label for="password">Lösenord</label> <input type="password" name="password" /><div class="error">&nbsp;<?php echo form_error('password'); ?></div>
<label for="passconf">Lösenord igen</label> <input type="password" name="passconf" /><div class="error">&nbsp;<?php echo form_error('passconf'); ?></div>
<label for="firstname">Förnamn</label> <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" /><div class="error">&nbsp;<?php echo form_error('firstname'); ?></div>
<label for="surname">Efternamn</label> <input type="text" name="surname" value="<?php echo set_value('surname'); ?>" /><div class="error">&nbsp;<?php echo form_error('surname'); ?></div>
<button type="submit">Registrera</button>
</form>