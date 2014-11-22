<?php
global $apiuserlog_session;
?>
<div class="navbar navbar-default bg-primary important">
	<div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="<?= site_url('users/') ?>">
	        <img alt="Brand" height="30" src="<?= site_url('image.php?image=assets/images/icon.png&demo=resize&width=30&height=30') ?>">
	      	API Version <?= api_version() ?></a>
	    </div>

    	<?php if(empty($_SESSION['apiuserlog'])): ?>
	    	<p class="navbar-text navbar-right text-white important">
	    		<?php if(isset($_GET['register'])): ?>
	    			<a href="<?= site_url('users') ?>" class="navbar-link">
	    				<i class="fa fa-angle-left"></i>
	    				Back to Login</a>
	    		<?php else: ?>
	    			<a href="<?= site_url('users?register') ?>" class="navbar-link">Request API ID? here!</a>
	    		<?php endif; ?>
	    	</p>
    	<?php else: ?>
	    	<form action="<?= $_SERVER['PHP_SELF'] ?>?logout" method="post" class="logout-form navbar-form navbar-right">
	    		<input type="hidden" name="log_ses" value="<?= $apiuserlog_session ?>">
	    		<div class="form-group">
	    			<button type="submit" name="logout" class="btn btn-warning">
	    				<span class="glyphicon glyphicon-log-out"></span>
	    				Log-out
	    			</button>
	    		</div>
	    	</form>
    	<?php endif; ?>
    	
	 </div>
</div>