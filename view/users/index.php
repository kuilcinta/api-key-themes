<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

get_header(true,true);

if(isset($_GET['data']) AND $_GET['data']=='success'):
	get_template_php('inc/template','success');
else:
?>

<div class="container clearfix">

	<div class="row">
	
	<?php if(empty($_SESSION['apiuserlog'])): ?>

		<div class="col-lg-pull-4 col-lg-4 col-lg-push-4">
			<div class="page-header">
				<h2 class="row">
					<img class="col-xs-4 col-sm-2 col-md-3 col-lg-3 img-rounded" src="<?= site_url('assets/images/icon-flat.png') ?>" />
					<span class="col-xs-8 col-sm-10 col-md-9 col-lg-9 text-primary font-primary f-size-100cent">
						<?php
						if(isset($_GET['register'])):
							echo 'Register Your Site<br />'.site_title();
						else:
							echo author_name().'<br />'.site_title();
						endif;
						?>
					</span>
				</h2>
			</div>

			<?php get_global_alert() ?>

			<?php
			if(isset($_GET['data']) AND $_GET['data']=='register'):
				echo '<div class="separator">';
				get_template_php('inc/template','register');
				echo '</div>';
			else:
				echo '<div class="form_access">';
				get_template_php('inc/template','form-login');
				echo '</div>';
			endif;
			?>
		</div>

	<?php else: ?>

		<div class="col-lg-pull-2 col-lg-8 col-lg-push-2">
			<?php if(isset($_GET['data']) AND $_GET['data']=='change'): ?>
				<?php get_template_php('inc/template','change-user'); ?>
			<?php else: ?>
				<?php get_template_php('inc/template','dashboard'); ?>
			<?php endif; ?>
		</div>

	<?php endif; ?>

	</div>

</div>

<?php

endif;

get_footer();

?>