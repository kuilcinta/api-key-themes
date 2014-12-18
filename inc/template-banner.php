<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

$dataslide = slide_home();

?>

<ul class="cb-slideshow bg-primary">

	<?php for($f=0;$f<count($dataslide['data']);$f++){ ?>
	    <li>
	    	<span></span>
    		<div>
    			<h3 class="border-white border-bottom border-1px border-solid">
    				<?= $dataslide['data'][$f+1][0] ?></h3>
    		</div>
	    </li>
	<?php } ?>

</ul>