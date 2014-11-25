<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

$data = slide_home();
?>

<ul class="cb-slideshow bg-primary">

	<?php for($f=0;$f<count($data);$f++){ ?>
	    <li>
	    	<span></span>
    		<div>
    			<h3 class="border-white border-bottom border-1px border-solid">
    				<?= $data[$f] ?>
    			</h3>
    		</div>
	    </li>
	<?php } ?>

</ul>