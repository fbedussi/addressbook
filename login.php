<div class="row text-center">
	<form class="center col-xs-12 bg-info" id="login-form" name="login" method="POST" action="index.php">
		<div class="form-group">
			<label><?php print USER_NAME.':';?></label>
			<p class="filed"><input name="user" type="text" id="user"></p>
			<label><?php print PASSWORD.':'; ?></label>
			<p class="field"><input name="pwd" type="password" id="pwd"></p>
			<p><input class="btn btn-primary" name="Submit" type="submit" value="<?php print ENTER; ?>"></p>
			
		</div>
	</form>
	<p>Nome utente: prova // Password: prova</p>
</div>
