<?php

function is_login(){
	if(empty($_SESSION['apiuserlog'])){
		return false;
	}
	else{
		return array(true,$_SESSION['apiuserlog']);
	}
}

/**
 * get_master_data() function
 * Handling access master.txt file for meta data API
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return file_get_contents()
 */
function get_master_data(){
	return file_get_contents(BASEDIR.'/master.ms');
}

function get_meta_tag_value($metaname=false){
	$grab = get_master_data();
	/* Memotong karakter tag pembuka */
	$grab = strstr($grab, "<$metaname>");
	/* Memotong karakter tag penutup */
	$grab = strstr($grab, "/$metaname>", true);
	/* Menghitung jumlah karakter metaname ditambah 2 karakter < & >
	 * Kemudian mengambil isi dari pemotongan tag penutup & pembuka */
	$grab = substr($grab,strlen($metaname)+2,-1);
	return $grab;
}

function explode_grab($metaname){
	$grab = get_meta_tag_value($metaname);
	$grab = explode('|', $grab);
	$grab = is_array($grab) ? $grab : null;
	if($grab!=null){
		foreach($grab as $k => $v){
			$arrgrab[] = $v;
		}
	}
	return $arrgrab;
}

function get_web_client_array(){
	$data = get_meta_tag_value('apiclient');
	return explode('|', $data);
}

function load_web_client_options(){
	$data = get_web_client_array();
	$r ='<select name="reg_client" class="form-control">';
	foreach ($data as $k => $v) {
		$r .= '<option value="'.strtolower(preg_replace('/( )/','_',$v)).'">'.$v.'</option>';
	}
	$r .= '</select>';
	return $r;
}

/**
 * @since v.1.0
 * Fungsi truncate
 * Membuat pembatasan karakter teks dalam bentuk string
 */
function truncate($input, $maxWords, $maxChars){
    $words = preg_split('/\s+/', $input);
    $words = array_slice($words, 0, $maxWords);
    $words = array_reverse($words);

    $chars = 0;
    $truncated = array();

    while(count($words) > 0)
    {
        $fragment = trim(array_pop($words));
        $chars += strlen($fragment);

        if($chars > $maxChars) break;

        $truncated[] = $fragment;
    }

    $result = implode($truncated, ' ');
    return $result . ($input == $result ? '' : '...');
}

function load_style($args=false,$p=true){
	$render = '<!-- Stylesheet -->'."\n";
	foreach ($args as $k => $v) {
		$render .= '<link href="'.site_url('assets/css/'.$v).'" media="all" type="text/css" rel="stylesheet" />'."\n";
	}

	if($p==true){ echo $render; }
	else{ return $render; }
}

function convert_date($s){
	$date = strtotime($s);
	$date = date('l, j F Y - h:i:s A',$date);
	return $date;
}
/**
 * @since v.1.0
 * Fungsi get_uri_index
 * Mengambil data URI dan memangkas index setelah dirubah jadi array
 */
function get_uri_index($index){
    $u = $_SERVER['REQUEST_URI'];
    $u = explode('/', $u);        
    $total = count($u);
    $rearray = array();
    for($i=$index;$i<$total;$i++){
        array_push($rearray, $u[sizeof($u)-$i]);
    }
    return join('/',array_reverse($rearray));
}

function br2nl($string){
    return preg_replace('#<br\s*/?>#i', "\r\n", $string);        
}

function load_script($args=false,$p=true){
	$render = '<!-- JavaScript -->'."\n";
	foreach ($args as $k => $v) {
		$render .= '<script src="'.site_url('assets/js/'.$v).'" type="text/javascript"></script>'."\n";
	}

	if($p==true){ echo $render; }
	else{ return $render; }
}

function load_favicon($p=true){
	$render = '<!-- Favicon -->'."\n";
	$render .= '<link rel="shortcut icon" href="'.site_url('favicon.ico').'" type="image/x-icon" />'."\n";
	$render .= '<link rel="icon" href="'.site_url('favicon.ico').'" />'."\n";

	if($p==true){ echo $render; }
	else{ return $render; }
}

function load_data_script(){ ?>
	<script type="text/javascript">
		var domain = "<?= site_url() ?>";
		<?php if(empty($_SESSION['apiuserlog'])): ?>
		var login = false;
		<?php else: ?>
		var login = true;
		<?php endif; ?>
		
		<?php if(empty($_SESSION['ofansession'])): ?>
		var ofanse = false;
		<?php else: ?>
		var ofanse = true;
		<?php endif; ?>
	</script>
<?php
}

function load_head($args=false){ ?>
	<title><?= site_title() ?></title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="author" content="<?= author_name() ?>" />
	<?php
	$suffix_mod = IS_DEV;
	load_favicon(true);

	if($args['script']==true){
		load_data_script();
		load_script(
			array('turbolinks'.$suffix_mod.'.js',
				  'jquery-1.11.1'.$suffix_mod.'.js',
				  'jquery-turbolinks'.$suffix_mod.'.js',
				  'bootstrap'.$suffix_mod.'.js',
				  'script'.$suffix_mod.'.js'
				  ),
			true);
	}
	
	if($args['style']==true){
		load_style(
			array('bootstrap'.$suffix_mod.'.css',
				  'bootstrap-theme'.$suffix_mod.'.css',
				  'bootstrap-addons'.$suffix_mod.'.css',
				  'font-awesome'.$suffix_mod.'.css',
				  'style'.$suffix_mod.'.css'
				  ),
			true);
	}
}

function get_error_alert(){
	if(isset($_GET['error'])): ?>
		<div class="alert alert-danger">
			<a href="<?= $_SERVER['REQUEST_URI'] ?>" class="pull-right">tutup</a>
			<?= isset($_GET['msg']) ? statusCode($_GET['msg'],'en') : '' ?>
		</div>
	<?php endif;
}

function get_header($script=false,$style=false){
//$apiuserlog_session = $_SESSION['apiuserlog'];
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php load_head(array('script'=>$script,'style'=>$style)) ?>
</head>
<body>
<div class="wrapper clearfix">
<header>
<?php get_template_php('includes/template','navbar') ?>
</header>
<section class="clearfix">
<?php
}

function get_footer(){ ?>
</section>
<?php get_template_php('includes/template','footer') ?>
</div>
</body>
</html>
<?php
}

function get_template_php($file='',$name=''){
	if($file!='' && $name!=''){
		$ext = '.php';
		$full_file_name = dirname(__FILE__).'/../'.$file.'-'.$name.$ext;
		if(file_exists($full_file_name)){
			include($full_file_name);
		}
		else{
			$full_file_name_dir = dirname(__FILE__).'/'.$file.'-'.$name.$ext;
			if(file_exists($full_file_name_dir)){
				include($full_file_name);
			}
		}
	}
}

function load_error_template($headinfo=true,$header=true,$footer=false){
	if($headinfo==true)
		header("HTTP/1.0 400 Bad Request");

	if($header==true)
		get_header(false,true);

	get_template_php('includes/template','error');

	if($footer==true)
		get_footer();
}

function to_link($url='',$text='',$target='_blank',$title=''){
	return '<a href="'.$url.'" target="'.$target.'" '.($title ? $title : $text).'>'.$text.'</a>';
}
?>