<?php
ob_start("ob_gzhandler");
//session_start();

require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../lib/key.php');

//if(isset($_SESSION['ofansession'])) exit('berhasil login');

get_header(true,true);
?>
<div class="container clearfix">

	<div class="row">
	
	<?php if(empty($_SESSION['ofansession'])): ?>

		<div class="col-lg-pull-4 col-lg-4 col-lg-push-4">
			<div class="page-header text-center">
				<h2>Check All Request</h2>
			</div>

			<?php if(isset($_GET['error'])): ?>
				<div class="alert alert-danger">
					<?= isset($_GET['msg']) ? statusCode($_GET['msg']) : '' ?>
				</div>
			<?php endif; ?>

			<?php get_template_php('includes/template','ofan-access') ?>
		</div>

	<?php else: ?>

		<div class="col-lg-pull-2 col-lg-8 col-lg-push-2">
			<?php if(isset($_GET['edit'])): ?>
				<?php get_template_php('includes/template','edit-api'); ?>
			<?php else: ?>
				<?php get_template_php('includes/template','data-api'); ?>
			<?php endif; ?>
		</div>

	<?php endif; ?>

	</div>

</div>

<?php
get_footer();

ob_end_flush();
?>