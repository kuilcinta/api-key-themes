<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template Edit setting
 *
 * @author Ofan Ebob
 * @since v1.0
 */

$setting_id = $_GET['id'];

$data_setting = array('prm'=>"WHERE opt_id=$setting_id");

$Setting = new Setting($data_setting);
$setting_db = $Setting->read_site_opt()->fetch_array();

if(isset($_POST['push']) AND $_POST['push'] == '1')
{
	$setting_name = $setting_db['opt_name'];

	$ClassSetting = new Setting(
					array('prm'=>array(
								  'opt_value'=>$_POST['edit_value'],
					  			  'opt_permanent'=>$_POST['edit_permanent']
				  			  	),
						  'con'=>"WHERE opt_id=$setting_id AND opt_name='{$setting_name}'"
						)
					);

	$update_setting_db = $ClassSetting->update_site_opt();

	if($update_setting_db == true){
		get_global_alert(200);
	}
	else{
		get_global_alert(422);
	}
}
elseif(isset($_GET['drop']))
{
	if($_GET['drop'] == '0')
	{
		get_form_drop(
						array('input_hidden'=>array('id'=>$setting_db['opt_id']),
							  'submit'=>array('value'=>'Yes delete it!','class'=>'btn btn-danger'),
							  'title'=>'Are you sure to delete?',
							  'suffix'=>'setting_',
							  'form'=>array('action'=>$_SERVER['PHP_SELF'].'?edit=setting&drop=1&id='.$setting_db['opt_id'],
							  				'method'=>'post'
							  				),
							  'print'=>true
							 )
					);
	}
	elseif($_GET['drop'] == '1')
	{
		$data = array('id'=>$_POST['opt_id']);

		/*print_r($data);*/

		$ClassSetting = new Setting($data);
		
		$delete_setting = $ToJson->delete_setting();

		if($delete_setting == true)
		{
			redir(site_url('ebob/data/setting/alert-Success+Deleting+setting'));
		}
		else{
			redir(site_url('ebob/edit/setting/'.$setting['setting_index'].'/alert-422'));
		}
	}
}

$full_name = ucwords(preg_replace('/\_/',' ',$setting_db['opt_name']));
?>

<div class="page-header row">
<h1 class="col-lg-8">
	<i class="glyphicon glyphicon-list-alt v-align-top"></i>
	Edit <?= $full_name ?></h1>
<div class="col-lg-4 text-right">
	<a href="<?= site_url('ebob/data/setting') ?>" class="btn btn-primary">
		<i class="fa fa-angle-left"></i>
		Back to Front</a>
</div>
</div>

<div class="spearator">
<form action="<?= $_SERVER['PHP_SELF'] ?>?edit=setting&id=<?= $setting_db['opt_id'] ?>&push=1" method="post" class="marginspace-bottom">

		<div class="form-group">
	    	<div class="input-group w-100cent">
	    		<label for="edit_name">Setting Name</label>
	    		<input readonly value="<?= $setting_db['opt_name'] ?>" name="edit_name" type="text" class="input form-control" />
	    	</div>
	    </div>
		<div class="form-group">
	    	<div class="input-group w-100cent">
	    		<label for="edit_value">Setting Value</label>
	    		<textarea rows="4" name="edit_value" class="input form-control"><?= $setting_db['opt_value'] ?></textarea>
	    	</div>
	    </div>

		<div class="form-group">
	    	<div class="input-group w-100cent">
	    		<?php
	    		$data_status = array(1=>'Permanent',0=>'Temporary');

	    		foreach($data_status as $sta => $tus):
	    		?>

	    		<label>
	    			<input value="<?= $sta ?>" name="edit_permanent" type="radio" <?= $setting_db['opt_permanent'] == $sta ? 'checked' : '' ?> />
	    			<?= $tus ?></label>
	    			&nbsp;

	    		<?php endforeach; ?>

	    	</div>
	    </div>
		<div class="form-group text-right">
			<input type="hidden" name="push" value="1" />
			<?php if($setting_db['opt_permanent'] != 1): ?>
				<a href="<?= site_url('ebob?edit=setting&drop=0&id='.$setting_db['opt_id']) ?>" class="btn btn-danger">Delete setting</a>
			<?php endif; ?>
	    	<input value="Update Setting" type="submit" class="btn btn-primary">
	    </div>
	</div>
</form>

</div>