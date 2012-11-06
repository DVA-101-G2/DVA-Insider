<?php if($form): ?>
<?php echo form_open(''); ?>
<textarea style="width:100%;height:500px;" name="content" class="ckeditor"><?php echo $data->content; ?></textarea><br />
<button type="submit">Uppdatera Widget</button>
</form>
<?php else: ?>
<script>
closePopup();
</script>
<?php endif; ?>