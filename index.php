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

	<div id="banner"></div>

	</div>

</div>

<?php

endif;

get_footer();

ob_end_flush();
?>