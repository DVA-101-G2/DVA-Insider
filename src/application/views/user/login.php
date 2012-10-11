<?php if(isset($success)): ?>
<script>
setTimeout(function() {
closePopup();
window.location.reload();
}, 1500);
</script>
Du loggades in!
<?php else: ?>
<table border="0">
<tr>
<td>
<form action="">
<label for="email">E-postadress</label> <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
<label for="password">Lösenord</label> <input type="password" name="password" />
<div class="error">&nbsp;<?php if(isset($error)): ?>Användarnamn eller lösenord var fel, försök igen<?php endif; ?></div>
<button type="submit">Logga in</button>
</form>
</td>
<td style="width:20px;"></td>
<td style="vertical-align:top;">
Inte registrerad ännu? Du kan registera dig genom att trycka på registrera nedan.<br /><br />
<div style="text-align:center;"><?php echo anchor('user/register', 'Registrera', 'class="popup button" rel="Registering"'); ?></div>
</td>
</tr>
</table>
<?php endif; ?>