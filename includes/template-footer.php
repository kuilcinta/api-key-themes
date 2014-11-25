<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404'); ?>

<footer id="footer" class="z-index-999">
	<div class="container clearfix bg-white border-1px border-top border-smoke border-solid text-gray">
		&copy; <?= date('Y').' '.to_link(get_author_master_data('url'),get_author_master_data('name')) ?>
	</div>
</footer>