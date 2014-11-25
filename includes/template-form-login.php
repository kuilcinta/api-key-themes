<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

if(isset($_GET['login'])){
	global $Users;
	if(isset($_POST['log_usn']) && isset($_POST['log_pass'])){
		$Users->login($_POST['log_usn'],$_POST['log_pass'],0,'redirect');
	}
}
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>?login" method="post" id="form-login" class="">
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			<input name="log_usn" id="user_login" class="input form-control" placeholder="Username" value="" size="20" type="text">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			<input name="log_pass" id="user_login" class="input form-control" placeholder="Password" value="" size="20" type="password">
		</div>
	</div>
	<div class="form-group nomargin">
		<div class="row">
			<div class="col-lg-6 v-align">
				<input name="remember" id="remember" type="checkbox">
				<label>Remember me!</label>
			</div>
			<div class="col-lg-6 text-right">
				<input name="submit" id="submit" class="btn btn-primary" value="Log In" type="submit">
			</div>
		</div>
	</div>											
</form>