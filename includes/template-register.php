<?php
if(isset($_GET['register']) AND $_GET['register'] == '1'){
	if(isset($_POST['reg_usn']) && isset($_POST['reg_pass']) && isset($_POST['reg_email']) && isset($_POST['reg_domain'])){
		$data = array('usn'=>$_POST['reg_usn'],
					  'pass'=>$_POST['reg_pass'],
					  'email'=>$_POST['reg_email'],
					  'domain'=>$_POST['reg_domain'],
					  'client'=>$_POST['reg_client']
					 );
		$ToJson = new ToJson($data);
		$ToJson->process_new_key();
	}
}
?>
<form action="<?= $_SERVER['PHP_SELF'] ?>?register=1" method="post" id="form-register" class="separator">
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			<input name="reg_usn" id="user_reg" class="input form-control" placeholder="Username" type="text">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
			<input name="reg_email" id="email_reg" class="input form-control" placeholder="Email" type="email">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			<input name="reg_pass" id="pass_reg" class="input form-control" placeholder="Password" type="password">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-link"></span></span>
			<input name="reg_domain" id="domain_reg" class="input form-control" placeholder="Domain" type="text">
		</div>
	</div>
	<div class="form-group">
		<label form="reg_client">Select Type API, for:</label>
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
			<?= load_web_client_options() ?>
		</div>
	</div>
	<div class="form-group text-right">
		<input name="submit" id="submit" class="btn btn-danger" value="Register New API" type="submit">
	</div>											
</form>