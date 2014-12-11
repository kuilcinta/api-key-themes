<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

global $Users, $userid_session;

$user_data = $Users->get_user_db_array(array('where'=>"user_id=$userid_session"));

if(isset($_POST['push']) AND $_POST['push'] == 1)
{
	$pass = empty($_POST['log_pass']) ? $user_data['user_pass'] : md5($_POST['log_pass']);
	$Users->edit_user_data(
			array('id'=>$userid_session,
	  			  'pass'=>$pass,
	  			  'mail'=>$_POST['log_mail'],
	  			  'fname'=>$_POST['log_fname'],
	  			  'lname'=>$_POST['log_lname']
				 )
	);
}

?>
<div class="page-header row">
	<h1 class="col-lg-8">
		Edit Account Data <?= $user_data['user_firstname'] ?>
	</h1>
	<div class="col-lg-4 text-right">
		<a href="<?= site_url('users') ?>" class="btn btn-primary">
			<i class="fa fa-angle-left"></i>
			Back to Dashboard</a>
	</div>
</div>

<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" id="form-login" class="margin-bottom">
	<div class="form-group">
	    <div class="input-group w-100cent">
	    	<label for="log_usn">Username:</label>
			<input value="<?= $user_data['user_name'] ?>" name="log_usn" id="username" class="input form-control" placeholder="Username" type="text" disabled>
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group w-100cent">
	    	<label for="log_pass">Password:</label>
			<input name="log_pass" id="password" class="input form-control" placeholder="Password" type="text">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group w-100cent">
	    	<label for="log_mail">Email:</label>
			<input value="<?= $user_data['user_email'] ?>" name="log_mail" id="email" class="input form-control" placeholder="Email" type="email">
		</div>
	</div>
	<div class="form-group">
	    <div class="input-group w-100cent">
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="log_fname">Full Name:</label>
					<input value="<?= $user_data['user_firstname'] ?>" name="log_fname" id="fname" class="input form-control" placeholder="First Name" type="text">
				</div>
				<div class="col-lg-6">
					<label for="log_lname">Last Name:</label>
					<input value="<?= $user_data['user_lastname'] ?>" name="log_lname" id="lname" class="input form-control" placeholder="Last Name" type="text">
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group">
			<input type="hidden" name="push" value="1" />
			<input name="submit" id="submit" class="btn btn-primary" value="Save Editing" type="submit">
		</div>
	</div>
</form>