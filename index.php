<?php
/* Clear header send output */
ob_start("ob_gzhandler");

/* Defining base system config */
require_once(dirname(__FILE__).'/config.php');

/* Set condition site compressing setting */
if(site_compressing() == 1)
{
	api_html_compression_start();
}

/* Set global logout process */
get_logout_process();

/* Set cindition dynamic pages/URL */
if(isset($_GET['page']) AND $_GET['page']=='error'):
	load_error_template(true,true,false);

	get_footer();

elseif(isset($_GET['view'])):
	get_template_php('view/'.$_GET['view'],'index','/',true);

elseif(isset($_GET['page']) AND $_GET['page'] == 'verify'):
	$code_verify = isset($_GET['c']) ? $_GET['c'] : null;
	verify_account($code_verify);

else:

	if(isset($_SESSION['apiuserlog'])) redir(site_url('users'));

	get_header(true,true);

	?>

	<style><?php slide_home_css() ?></style>

		<div class="container clearfix">
				<?php get_template_php('inc/template','frontpage') ?>
		</div>

	<?php

	get_footer(false);

endif;

ob_end_flush();
?>