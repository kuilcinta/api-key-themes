<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404'); ?>

<div class="container clearfix">
	<div class="row">
		<div class="col-lg-pull-1 col-lg-10 col-lg-push-1">
			<div class="jumbotron">
			  <h1>Error <?= (isset($_GET['msg']) ? $_GET['msg'] : 500) ?></h1>
			  <p><?= statusCode( (isset($_GET['msg']) ? $_GET['msg'] : 500), 'en' ) ?></p>
			  <p><a class="btn btn-primary" href="<?= site_url('users') ?>" role="button">Back To Home</a></p>
			</div>
		</div>
	</div>
</div>