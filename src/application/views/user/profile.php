<div id="BoxOverblick">
	<div id="innerpicOverblick"><img src="<?php echo site_url('user/image/'.$user->user_id); ?>" height="190" width="190"></div>
	<div id="Overblickinfo">
		<ul>
			<li>Ingen info angiven</li>
		</ul>	
	</div>
	<div id="">
		<div id="innerOverblickname"><?php echo $user->user_firstname; ?> <?php echo $user->user_surname; ?></div>
		<div id="">
		<a href="http://www.twitter.com" target="_blank"><div id="innerOverblickLink1" ></div></a>
		<a href="http://www.facebook.com" target="_blank"><div id="innerOverblickLink2"></div></a>
		</div>
	</div>
</div>
<div style="clear:left;"></div>
<div class="BoxContent widgets<?php if($this->session->userdata('user_id') == $user->user_id): ?> owner<?php endif; ?>" id="widgets-user-<?php echo $user->user_id; ?>">
<?php foreach($widgets as $widget): ?>
	<div class="widget" id="widget-<?php echo $widget->widget_id; ?>"></div>
<?php endforeach;?>
</div>
<div id="BoxSenAktiv">
	<div id="innercontainerSenHeader"></div>
	
	<div id="innercontainerSen">
		<div id="Flodet">
				<ul>
					<li>Inga Aktiviteter...</li>

				</ul>


		</div>

	</div>
</div>