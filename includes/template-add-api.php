<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template Add API
 *
 * @author Ofan Ebob
 * @since v1.0
 */

global $Users;

if(isset($_POST['push']) AND $_POST['push'] == 1)
{
	$data = array('id'=>empty($_POST['add_id']) ? null : $_POST['add_id'],
	  			  'usn'=>empty($_POST['add_user']) ? null : $_POST['add_user'],
	  			  'domain'=>empty($_POST['add_domain']) ? null : $_POST['add_domain'],
	  			  'valid'=>empty($_POST['add_valid']) ? null : $_POST['add_valid'],
	  			  'client'=>empty($_POST['add_client']) ? null : $_POST['add_client'],
	  			  'status'=>empty($_POST['add_stats']) ? null : $_POST['add_stats']
				);
					
	$ToJson = new ToJson($data);

	$generate_api = $ToJson->generate_api();

	if($generate_api == 200)
	{
		redir(site_url('ebob/api'));
	}
	else
	{
		get_global_alert($generate_api);
	}
}

?>

<div class="page-header row">
<h1 class="col-lg-8">
	<i class="glyphicon glyphicon-list-alt v-align-top"></i>
	Add New API
</h1>
<div class="col-lg-4 text-right">
	<a href="<?= site_url('ebob/api') ?>" class="btn btn-primary">
		<i class="fa fa-angle-left"></i>
		Back to Front</a>
</div>
</div>

<div class="spearator">
<form action="<?= site_url('ebob/add/api') ?>" method="post" class="marginspace-bottom">
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="add_user">API User</label>
					<?= $Users->markup_options_user_list(array('name'=>'add_user')) ?>
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="add_id">API ID</label>
		    		<input value="<?= rand(100,999).time() ?>" name="add_id" type="text" class="input form-control" />
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="add_domain">API DOMAIN</label>
		    		<input  name="add_domain" type="text" class="input form-control" />
		    	</div>
		    </div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label for="add_valid">API VALID</label>
		    	<div id="valid_date" class="input-group w-100cent date input-append" data-date="<?= date('Y-m-d') ?>T15:25:00Z">
	    			<input readonly name="add_valid" type="text" class="input form-control" />
					<span class="add-on input-group-addon"><i class="icon-calendar glyphicon glyphicon-calendar"></i></span>
		    	</div>
		    </div>
		    <script type="text/javascript">
				$(function(){
				    $('#valid_date').datetimepicker({
						format: "yyyy-mm-dd HH:ii:ss",
						autoclose: true,
						todayBtn: true,
						startDate: "<?= date('Y-m-d H:i') ?>",
						minuteStep: 10,
						pickerPosition: "bottom-left"
				    });
				});
			</script>
			<div class="form-group">
		    	<div class="input-group w-100cent">
		    		<label for="add_client">Type API Client</label>
		    		<?= load_web_client_options(array('name'=>'add_client')) ?>
		    	</div>
		    </div>
			<div class="form-group">
		    	<div class="input-group w-100cent">

		    		<?php
		    		$data_status = array('Y'=>'Active','N'=>'Inactive','B'=>'Banned');

		    		foreach($data_status as $sta => $tus):
		    		?>

		    		<label>
		    			<input value="<?= $sta ?>" name="add_stats" type="radio" <?= $sta == 'N' ? 'checked' : '' ?> />
		    			<?= $tus ?></label>
		    			&nbsp;

		    		<?php endforeach; ?>

		    	</div>
		    </div>
			<div class="form-group text-right">
				<input type="hidden" name="push" value="1" />
		    	<input value="Create API" type="submit" class="btn btn-primary">
		    </div>
		</div>
	</div>
</form>

</div>