<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

global $ofan_session;

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

			<?php get_template_php('inc/template','ofan-access') ?>

		</div>

	<?php else: ?>

		<div class="col-lg-pull-1 col-lg-10 col-lg-push-1">

			<?php

			if( isset($_GET['data']) ):
				get_template_php('inc/template','data-'.$_GET['data']);
			elseif( isset($_GET['edit']) ):
				get_template_php('inc/template','edit-'.$_GET['edit']);
			elseif( isset($_GET['add']) ):
				get_template_php('inc/template','add-'.$_GET['add']);
			else:
				get_template_php('inc/template','data-api');
			endif;

			?>

		</div>

	<?php endif; ?>

	</div>

</div>

<?php
get_footer();
?>