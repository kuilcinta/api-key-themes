<?php
ob_start("ob_gzhandler");
//session_start();

require_once(dirname(__FILE__).'/../config.php');

get_header(true,true);

?>

<div class="container clearfix">

	<div class="row">
	
	<?php if(empty($_SESSION['apiuserlog'])): ?>

		<div class="col-lg-pull-4 col-lg-4 col-lg-push-4">
			<div class="page-header">
				<h2 class="row">
					<img class="col-lg-3 img-rounded" src="<?= site_url('image.php?image=assets/images/icon.png&demo=resize&width=50&height=50') ?>" />
					<span class="col-lg-9 text-primary f-size-100cent">
						<?php
						if(isset($_GET['register'])):
							echo 'Register Your Site '.site_title();
						else:
							echo author_name().' '.site_title();
						endif;
						?>
					</span>
				</h2>
			</div>

			<?php get_error_alert() ?>

			<?php
			if(isset($_GET['register'])):
			get_template_php('includes/template','register');
			else:
			get_template_php('includes/template','form-login');
			endif;
			?>
		</div>

	<?php else: ?>

		<div class="col-lg-pull-2 col-lg-8 col-lg-push-2">
			<?php if(isset($_GET['edit'])): ?>
				<?php get_template_php('includes/template','edit-user'); ?>
			<?php else: ?>
				<?php get_template_php('includes/template','dashboard'); ?>
			<?php endif; ?>
		</div>

	<?php endif; ?>

	</div>

</div>

<?php

get_footer();

ob_end_flush();
?>