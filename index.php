<?php
ob_start("ob_gzhandler");
//session_start();

require_once(dirname(__FILE__).'/config.php');

get_logout_process();

if(isset($_GET['page']) AND $_GET['page']=='error'):
	load_error_template(true,true,false);

	get_footer();
	
else:

if(isset($_SESSION['apiuserlog']))
	redir(site_url('users'));

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