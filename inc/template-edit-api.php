<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template Edit API
 *
 * @author Ofan Ebob
 * @since v1.0
 */

global $Users;
$api_index = $_GET['id'];

$data_user_api = array('order'=>'api_data.api_valid','where'=>"api_data.api_index=$api_index");

$api = array_fetch_db(get_api_user_merge_db($data_user_api),'read');

if(isset($_POST['push']) AND $_POST['push'] == 1)
{
	$ToJson = new ToJson(
					array('index'=>$api_index,
						  'id'=>$_POST['edit_id'],
			  			  'usn'=>$_POST['edit_user'],
			  			  'domain'=>$_POST['edit_domain'],
			  			  'value'=>$_POST['edit_value'],
			  			  'valid'=>$_POST['edit_valid'],
			  			  'client'=>$_POST['edit_client'],
			  			  'status'=>$_POST['edit_stats'],
						)
					);

	$update_api_db = $ToJson->update_api_db();

	if($update_api_db == true){
		get_global_alert(200);
	}
	else{
		get_global_alert(422);
	}
}
elseif(isset($_GET['drop']))
{
	get_form_drop(
		array('input_hidden'=>array('id'=>$api['api_id'],
									'index'=>$api['api_index'],
									'user'=>$api['api_user'],
									'push'=>1
							),
			  'submit'=>array('value'=>'Yes delete it!','class'=>'btn btn-danger'),
			  'title'=>'Are you sure to delete?',
			  'suffix'=>'api_',
			  'form'=>array('action'=>$_SERVER['REQUEST_URI'],
			  				'method'=>'post'
			  				),
			  'print'=>true
			 )
	);

	if(isset($_POST['api_push']) AND $_POST['api_push'] == 1)
	{
		$data = array('id'=>$_POST['api_id'],
					  'index'=>$_POST['api_index'],
					  'usn'=>$_POST['api_user']
					  );

		/*print_r($data);*/

		$ToJson = new ToJson($data);
		
		$delete_api = $ToJson->delete_api();

		if($delete_api == true)
		{
			redir(site_url('ebob/api'));
		}
		else{
			get_global_alert(422);
		}
	}
}

$full_name = $api['user_firstname'] .' '.$api['user_lastname'];
$api_value_status = ($api['api_value'] == '' OR $api['api_value'] == 'none') ? false : true;

?>

<div class="page-header row">
<h1 class="col-lg-8">
	<i class="glyphicon glyphicon-list-alt v-align-top"></i>
	Edit API <?= $full_name ?></h1>
<div class="col-lg-4 text-right">
	<a href="<?= site_url('ebob/api') ?>" class="btn btn-primary">
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
		    		<label for="edit_user">API User</label>
					<?= $Users->markup_options_user_list(array('selected'=>$api['api_user'],'name'=>'edit_user')) ?>
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="edit_id">API ID</label>
		    		<input value="<?= $api['api_id'] ?>" name="edit_id" type="text" class="input form-control" />
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="edit_domain">API DOMAIN</label>
		    		<input value="<?= $api['api_domain'] ?>" name="edit_domain" type="text" class="input form-control" />
		    	</div>
		    </div>
			<div class="form-group">
				<label for="edit_valid">API VALID</label>
		    	<div id="valid_date" class="input-group w-100cent date input-append" data-date="2013-02-21T15:25:00Z">
	    			<input readonly value="<?= $api['api_valid'] ?>" name="edit_valid" type="text" class="input form-control" />
					<span class="add-on input-group-addon"><i class="icon-calendar glyphicon glyphicon-calendar"></i></span>
		    	</div>
		    	<small>Until: <?= convert_date($api['api_valid']) ?></small>
		    </div>
		    <script type="text/javascript">
				$(function(){
				    $('#valid_date').datetimepicker({
						format: "yyyy-mm-dd HH:ii:ss",
						autoclose: true,
						todayBtn: true,
						startDate: "2013-02-14 10:00",
						minuteStep: 10,
						pickerPosition: "top-left"
				    });
				});
			</script>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="edit_value">API VALUE</label>
		    		<textarea rows="<?= $api_value_status == true ? 4 : 2 ?>" name="edit_value" class="input form-control"><?= $api['api_value'] ?></textarea>
		    	</div>
		    	<?php if($api_value_status == false): ?>
		    	<small class="well break-word-all w-100cent d-inline-block separator">
		    		<?= base64_encode(get_masterdata_format().'|'.$api['api_id'].'|'.strtotime($api['api_valid'])) ?>
		    	</small>
		    	<?php endif; ?>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="edit_client">Type API Client</label>
		    		<?= load_web_client_options(array('selected'=>$api['api_client'],'name'=>'edit_client')) ?>
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<?php
		    		$data_status = array('Y'=>'Active','N'=>'Inactive','B'=>'Banned');

		    		foreach($data_status as $sta => $tus):
		    		?>

		    		<label>
		    			<input value="<?= $sta ?>" name="edit_stats" type="radio" <?= $api['api_status'] == $sta ? 'checked' : '' ?> />
		    			<?= $tus ?></label>
		    			&nbsp;

		    		<?php endforeach; ?>

		    	</div>
		    </div>
			<div class="form-group text-right">
				<input type="hidden" name="push" value="1" />
				<a href="<?= site_url('ebob/edit/api/'.$api['api_index'].'/drop') ?>" class="btn btn-danger">Delete API</a>
		    	<input value="Update API <?= $full_name ?>" type="submit" class="btn btn-primary">
		    </div>
		</div>
	</div>
</form>

</div>