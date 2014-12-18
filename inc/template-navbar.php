<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

global $Users, $apiuserlog_session, $ofan_session;

//$position = BASENAME;

?>
<div class="navbar navbar-default bg-primary z-index-999">
	<div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand text-white important font-primary" href="<?= site_url('/') ?>">
	        <img alt="<?= slugging(author_name()) ?>" height="30" src="<?= site_url('image.php?image=assets/images/icon.png&demo=resize&width=30&height=30') ?>">
	      	API Version <?= api_version() ?></a>
	    </div>

    	<?php if($apiuserlog_session !=null OR $ofan_session != null): 
    	
    		//$log_ses = $position == 'ebob' ? $ofan_session : $apiuserlog_session;
    		$data_session = array('users'=>$apiuserlog_session,'ebob'=>$ofan_session);

    		foreach($data_session as $s => $d):

    		if($d != null):
    	?>

	    	<form action="<?= $_SERVER['PHP_SELF'] ?>?logout" method="post" class="logout-form navbar-form navbar-right">
	    		<input type="hidden" name="log_ses" value="<?= $d ?>">
	    		<input type="hidden" name="log_pos" value="<?= $s ?>">
	    		<div class="form-group">
	    			<button type="submit" name="logout" class="btn btn-warning">
	    				<span class="glyphicon glyphicon-log-out v-align-middle"></span>
	    				<?= ucwords( $s == 'users' ? $Users->get_decode_log_username($d) : $s ) ?>
	    				Log-out
	    			</button>
	    		</div>
	    	</form>

    	<?php
    		endif;
    		endforeach;

    	else: ?>

    		<div class="nav navbar-nav navbar-right">
	    		<div class="collapse navbar-collapse" id="navbar-collapse-topmenu">
		    		<?php if(isset($_GET['register'])): ?>
		    			<a href="<?= site_url('users') ?>" class="navbar-btn btn btn-primary">
		    				<i class="fa fa-angle-left v-align-middle"></i>
		    				Back to Login</a>
		    		<?php else: ?>
		    			<a href="<?= site_url('users/register') ?>" class="navbar-btn btn btn-danger">
		    				Register New API
		    			</a>
		    			<a href="<?= site_url('users') ?>" class="navbar-btn btn btn-primary">
		    				<i class="glyphicon glyphicon-lock v-align-middle"></i>
		    				Login
		    			</a>
		    		<?php endif; ?>
	    		</div>
    		</div>

    	<?php endif; ?>
    	
	 </div>
</div>