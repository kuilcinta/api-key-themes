<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

if(isset($_GET['access'])){
	global $Ofan, $KeyLogging;
	if(isset($_POST['key'])){
		return $KeyLogging->access($_POST['key']);
	}
}
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>?access" method="post" id="form-login" class="form_access">
	<div class="form-group">
	    <div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			<input name="key" id="key" class="input form-control" placeholder="What the code" value="" size="20" type="text">
		</div>
	</div>
	<div class="form-group">
		<div class="text-right">
			<input name="submit" id="submit" class="btn btn-warning" value="Check-in" type="submit">
		</div>
	</div>
	</div>
</form>