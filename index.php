<?php
/* Clear header send output */
ob_start("ob_gzhandler");

/* Defining base system config */
require_once(dirname(__FILE__).'/config.php');

/* Set global logout process */
get_logout_process();

/* Set cindition dynamic pages/URL */
if(isset($_GET['page']) AND $_GET['page']=='error'):
	load_error_template(true,true,false);

	get_footer();

elseif(isset($_GET['view'])):
	$view_files = dirname(__FILE__).'/view/'.$_GET['view'].'/index.php';
	if(file_exists($view_files)):
		require_once($view_files);
	else:
		redir(site_url('page=error&msg=404'));
	endif;

elseif(isset($_GET['page']) AND $_GET['page'] == 'verify'):
	$code_verify = isset($_GET['c']) ? $_GET['c'] : null;
	verify_account($code_verify);

else:

	if(isset($_SESSION['apiuserlog'])) redir(site_url('users'));

	get_header(true,true);

	?>

	<style><?php slide_home_css() ?></style>

		<div class="container clearfix">
				<?php get_template_php('includes/template','frontpage') ?>
		</div>

	<?php

	get_footer(false);

endif;

ob_end_flush();
?>