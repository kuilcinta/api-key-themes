<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

?>

<div class="row">
	<div class="col-lg-8">
		<?php get_template_php('inc/template','banner') ?>
	</div>

	<div class="col-lg-4">
		<div class="separator">
			<div class="form-decoring spaces">
				<?php get_template_php('inc/template','form-login') ?>
			</div>
			<div class="form-decoring">
				<h3 class="nomargin font-primary" style="padding:5px">Not Registered?</h3>
				<?php get_template_php('inc/template','register') ?>
			</div>
		</div>
	</div>
</div>