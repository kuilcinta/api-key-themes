<?php
ob_start("ob_gzhandler");
//session_start();

require_once(dirname(__FILE__).'/config.php');

if(isset($_GET['page']) AND $_GET['page']=='error'):
	load_error_template(true,true,false);
else:

get_header(true,true);

?>

<div class="container clearfix">

	<div class="row">
	
	<div class="col-lg-pull-4 col-lg-4 col-lg-push-4">
		<div class="page-header">
			<h2 class="row">

			</h2>
		</div>
	</div>

	</div>

</div>

<?php

endif;

get_footer();

ob_end_flush();
?>