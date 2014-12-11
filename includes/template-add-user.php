<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template Add user
 *
 * @author Ofan Ebob
 * @since v1.0
 */

global $Users;

if(isset($_POST['push']) AND $_POST['push'] == 1)
{
	$user_name = empty($_POST['add_usn']) ? null : $_POST['add_usn'];
	$user_pass = empty($_POST['add_pass']) ? null : $_POST['add_pass'];

	$params = array('fname'=>empty($_POST['add_fname']) ? ucwords($user_name) : $_POST['add_fname'],
		  			'lname'=>empty($_POST['add_lname']) ? '' : $_POST['add_lname'],
		  			'valid_cache'=>empty($_POST['add_valid']) ? null : $_POST['add_valid'],
		  			'email'=>empty($_POST['add_email']) ? null : $_POST['add_email'],
		  			'status'=>empty($_POST['add_stats']) ? null : $_POST['add_stats']
				);
					
	$UserService = new User_Service($user_name,$user_pass,$params);

	$generate_user = $UserService->generate_user();

	if($generate_user == true)
	{
		redir(site_url('ebob/user'));
	}
	else
	{
		get_global_alert(422);
	}
}

?>

<div class="page-header row">
<h1 class="col-lg-8">
	<i class="glyphicon glyphicon-list-alt v-align-top"></i>
	Add New User
</h1>
<div class="col-lg-4 text-right">
	<a href="<?= site_url('ebob/user') ?>" class="btn btn-primary">
		<i class="fa fa-angle-left"></i>
		Back to Front</a>
</div>
</div>

<div class="spearator">
	<form action="<?= site_url('ebob/add/user') ?>" method="post" class="marginspace-bottom">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_usn">User Name</label>
			    		<input name="add_usn" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_email">Email</label>
			    		<input name="add_email" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_fname">First Name</label>
			    		<input name="add_fname" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_lname">Last Name</label>
			    		<input name="add_lname" type="text" class="input form-control" />
			    	</div>
			    </div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_pass">Password</label>
			    		<input name="add_pass" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="add_valid">Valid Cache</label>
			    		<input  value="<?= strtotime('now') ?>" name="add_valid" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label>
			    			<input value="Y" name="add_stats" type="radio" />
			    			Active</label>
			    			&nbsp;
			    		<label>
			    			<input value="N" name="add_stats" type="radio" checked />
			    			Inactive</label>
			    	</div>
			    </div>
				<div class="form-group">
					<input type="hidden" name="push" value="1" />
			    	<input value="Create New User" type="submit" class="btn btn-primary">
			    </div>
			</div>
		</div>
	</form>

</div>