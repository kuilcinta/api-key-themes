<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template User
 *
 * @author Ofan Ebob
 * @since v1.0
 */

global $Users;

$user_id = $_GET['id'];
$data = array('where'=>"user_id=$user_id");
$user_db = $Users->access_user_db($data);
$user = array_fetch_db($user_db,'read');

if(isset($_POST['push']) AND $_POST['push'] == '1'){
	$user_id = $user['user_id'];
	$pass = empty($_POST['edit_pass']) ? $user['user_pass'] : md5($_POST['edit_pass']);
	$valid_cache = empty($_POST['edit_valid']) ? 0 : $_POST['edit_valid'];
	$update_user_db = $Users->update_user_db(
							array(	'id'=>$user_id,
									'prm'=>array( 'user_name'=>$_POST['edit_usn'],
									  			  'user_email'=>$_POST['edit_mail'],
									  			  'user_pass'=>$pass,
									  			  'user_firstname'=>$_POST['edit_fname'],
									  			  'user_lastname'=>$_POST['edit_lname'],
									  			  'user_valid_cache'=>$valid_cache,
									  			  'user_status'=>$_POST['edit_stats'],
									)
							)
					);

	if($update_user_db){
		get_global_alert(200);
	}
	else{
		get_global_alert(422);
	}
}
elseif(isset($_GET['drop']))
{
	get_form_drop(
				array('input_hidden'=>array('id'=>$user['user_id'],
											'name'=>$user['user_name'],
											'pass'=>$user['user_pass'],
											'push'=>1
									),
					  'submit'=>array('value'=>'Yes delete it!','class'=>'btn btn-danger'),
					  'title'=>'Are you sure to delete?',
					  'suffix'=>'user_',
					  'form'=>array('action'=>$_SERVER['REQUEST_URI'],
					  				'method'=>'post'
					  				),
					  'print'=>true
					 )
				);

	if(isset($_POST['user_push']) AND $_POST['user_push']==1)
	{
		$data = array('user_id'=>$_POST['user_id'],
					  'user_name'=>$_POST['user_name'],
					  'user_pass'=>$_POST['user_pass']
					  );

		/*print_r($data);*/

		$UserService = new User_Service(null,null,$data);
		
		$delete_user = $UserService->delete_user();

		if($delete_user == true){
			redir(site_url('ebob/user'));
		}
		else{
			get_global_alert(422);
		}
	}
}

?>


<div class="page-header row">
	<h1 class="col-lg-8">
		<i class="glyphicon glyphicon-user v-align-top"></i>
		Edit Account <?= $user['user_firstname'] ?></h1>
	<div class="col-lg-4 text-right">
		<a href="<?= site_url('ebob/user') ?>" class="btn btn-primary">
			<i class="fa fa-angle-left"></i>
			Back to Front</a>
	</div>
</div>

<div class="spearator">
	<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="marginspace-bottom">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_usn">User Name</label>
			    		<input value="<?= $user['user_name'] ?>" name="edit_usn" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_mail">Email</label>
			    		<input value="<?= $user['user_email'] ?>" name="edit_mail" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_fname">First Name</label>
			    		<input value="<?= $user['user_firstname'] ?>" name="edit_fname" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_lname">Last Name</label>
			    		<input value="<?= $user['user_lastname'] ?>" name="edit_lname" type="text" class="input form-control" />
			    	</div>
			    </div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_pass">Password</label>
			    		<input name="edit_pass" type="text" class="input form-control" placeholder="Leave blank password" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label for="edit_valid">Valid Cache</label>
			    		<input <?= (empty($user['user_valid_cache']) OR $user['user_valid_cache'] == 0) ? 'placeholder="'.strtotime('now').'"' : 'value="'.$user['user_valid_cache'].'"' ?> name="edit_valid" type="text" class="input form-control" />
			    	</div>
			    </div>
				<div class="form-group">
			    	<div class="input-group w-100cent">
			    		<label>
			    			<input value="Y" name="edit_stats" type="radio" <?= $user['user_status'] == 'Y' ? 'checked' : '' ?> />
			    			Active</label>
			    			&nbsp;
			    		<label>
			    			<input value="N" name="edit_stats" type="radio" <?= $user['user_status'] == 'N' ? 'checked' : '' ?> />
			    			Inactive</label>
			    	</div>
			    </div>
				<div class="form-group">
					<input type="hidden" name="push" value="1" />
					<a href="<?= site_url('ebob/edit/user/'.$user['user_id'].'/drop') ?>" class="btn btn-danger">Delete User</a>
			    	<input value="Update Account" type="submit" class="btn btn-primary">
			    </div>
			</div>
		</div>
	</form>

</div>