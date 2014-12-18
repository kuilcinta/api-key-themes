<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

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

function load_web_client_options($args=false){
	$name = isset($args['name']) ? $args['name'] : 'select';
	$selected = isset($args['selected']) ? $args['selected'] : '';
	return markup_select_html(array('data'=>get_web_client_array(),'name'=>$name,'selected'=>$selected));
}

function markup_select_html($args=false){
	$data = isset($args['data']) ? $args['data'] : null;
	$name_select = isset($args['name']) ? $args['name'] : 'select';
	$selected = isset($args['selected']) ? $args['selected'] : '';
	$value_type = isset($args['value_type']) ? ($args['value_type'] == true ? true : false) : false;

	if($data !== null){
		$r ='<select name="'.$name_select.'" class="form-control">';
		foreach ($data as $k => $v) {
			$values = strtolower(preg_replace('/( )/','_',$v));
			$values = $value_type == false ? $values : $k;
			$attr_select = $values == $selected ? 'selected' : '';
			$r .= '<option value="'.$values.'" '.$attr_select.'>'.$v.'</option>';
		}
		$r .= '</select>';
		return $r;
	}
	else{
		return 'NaN';
	}
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
			array('modernizr.custom.86080'.$suffix_mod.'.js',
				  'turbolinks'.$suffix_mod.'.js',
				  'jquery-1.11.1'.$suffix_mod.'.js',
				  'jquery-turbolinks'.$suffix_mod.'.js',
				  'bootstrap'.$suffix_mod.'.js',
				  'bootstrap-datetimepicker'.$suffix_mod.'.js',
				  'script'.$suffix_mod.'.js'
				  ),
			true);
	}
	
	if($args['style']==true){
		load_style(
			array('bootstrap'.$suffix_mod.'.css',
				  'bootstrap-theme'.$suffix_mod.'.css',
				  'bootstrap-datetimepicker'.$suffix_mod.'.css',
				  'bootstrap-addons'.$suffix_mod.'.css',
				  'slide-background'.$suffix_mod.'.css',
				  'style'.$suffix_mod.'.css'
				  ),
			true);
	}
}

function alert_markup($args=false){
	$type = isset($args['type']) ? $args['type'] : 'primary';
	$msg = isset($args['msg']) ? $args['msg'] : 'Error';
	$icon = isset($args['icon']) ? '<i class="'.$args['icon'].'"></i>&nbsp;' : '';
	$timeout = isset($args['timeout']) ? ($args['timeout'] == true ? 'alert-timout' : '') : '';

	$html = '
	<div class="alert alert-'.$type.' '.$timeout.'">
		'.$icon.'
		'.(is_numeric($msg) ? statusCode($msg,'en') : $msg).'
	</div>
	';
	return $html;
}

function get_global_alert($alert_code=false){
	if(is_numeric($alert_code)):
		
		if( in_array($alert_code, range(200,226)) ){
			$class = 'success';
			$icon = 'glyphicon glyphicon-ok';
		}
		elseif( in_array($alert_code, range(300,308)) ){
			$class = 'warning';
			$icon = 'glyphicon glyphicon-exclamation-sign';
		}
		elseif( in_array($alert_code, range(400,500)) ){
			$class = 'danger';
			$icon = 'fa fa-warning';
		}
		else{
			$class = 'info';
			$icon = 'glyphicon glyphicon-info-sign';
		}
		
		$data = array('type'=>$class,'msg'=>$alert_code,'icon'=>$icon);

		if(is_numeric($alert_code)){
			$data['timeout'] = true;
		}

		echo alert_markup($data);
	endif;
}

function get_logout_process(){
	global $Users, $KeyLogging;
	if(isset($_GET['logout'])){
		if(isset($_POST['log_ses']) AND isset($_POST['log_pos'])) {

			$log_proc = $_POST['log_pos'] == 'ebob' ? $KeyLogging->exits($_POST['log_ses']) : $Users->logout($_POST['log_ses']);

			if($log_proc == 200){
				redir(site_url());
			}
			else{
				redir($_SERVER['REQUEST_URI']);
			}
		}
	}
}

function get_form_drop($args=false)
{
	if(is_array($args))
	{
		$title = isset($args['title']) ? $args['title'] : null;
		$suffix = isset($args['suffix']) ? $args['suffix'] : '';
		$form = isset($args['form']) ? $args['form'] : array('action'=>$_SERVER['SELF_PHP'],'method'=>'POST');
		$submit = isset($args['submit']) ? $args['submit'] : null;
		$input_text = isset($args['input_text']) ? $args['input_text'] : null;
		$input_hidden = isset($args['input_hidden']) ? $args['input_hidden'] : null;
		$input_button = isset($args['input_button']) ? $args['input_button'] : null;
		$print = isset($args['print']) ? $args['print'] : false;

		$html = '<div class="panel panel-'.($title == null ? 'default' : 'danger').'">';

		if($title !== null)
		{
			$html .= '<div class="panel-heading"><h4 class="nomargin">'.$title.'</h4></div>';
		}

		$html .= '<div class="panel-body">';
		$html .= '<form action="'.$form['action'].'" method="'.$form['method'].'" id="'.$suffix.'form_drop">';
		if($input_text !== null)
		{
			foreach ($input_text as $index => $value) {
				$html .= '<div class="form-group"><div class="input-group w-100cent">';
		    	$html .= '<label for="'.$suffix.$index.'">'.ucwords(preg_replace('/\_/', '  ', $suffix).$index).'</label>';
				$html .= '<input type="text" name="'.$suffix.$index.'" value="'.$value.'" class="input form-control" />';
				$html .= '</div></div>';
			}
		}

		if($input_hidden !== null)
		{
			foreach ($input_hidden as $index => $value) {
				$html .= '<input type="hidden" name="'.$suffix.$index.'" value="'.$value.'" />';
			}
		}

		if($input_button !== null)
		{
			foreach ($input_button as $index => $value) {
				$html .= '<div class="form-group nomargin"><div class="input-group w-100cent text-right">';
				$html .= '<button class="btn btn-primary">'.$value.'</button>&nbsp;';
			}
		}
		else{
			$html .= '<div class="form-group nomargin"><div class="input-group w-100cent text-right">';
		}

		if($submit !== null)
		{
			$html .= '<input type="submit" value="'.$submit['value'].'" class="'.$submit['class'].'">';
		}

		$html .= '</div></div>';
		$html .= '</form>';
		$html .= '</div></div>';

		if($print==true)
		{
			echo $html;
		}
		else
		{
			return $html;
		}
	}
}

function get_pathdiruri_bool($string=null){
	$dir_name = preg_replace('/(\/)/','',dirname($position));
	$base_name = preg_replace('/(\/)/','',basename($position));
	return $dir_name == $string OR $base_name == $string ? true : false;
}

function get_header($script=false,$style=false,$args=array()){
//$apiuserlog_session = $_SESSION['apiuserlog'];
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php load_head(array('script'=>$script,'style'=>$style)) ?>
</head>
<body <?= isset($args['body_class']) ? 'class="'.$args['body_class'].'"' : '' ?>>
<div class="wrapper clearfix">
<header>
<?php get_template_php('inc/template','navbar') ?>
</header>
<section class="clearfix">
<?php
}

function get_footer($footertag=true){ ?>
</section>
<?php
if($footertag==true)
 get_template_php('inc/template','footer') ?>
</div>
</body>
</html>
<?php
}

function slide_home(){
	$data = array('path'=>site_url('assets/slides'),
				  'data'=>array(1=>array('With Self Hosting Server','1.jpg'),
				  				2=>array('Scalable Development','2.jpg'),
				  				3=>array('For User & Developer','3.jpg'),
				  				4=>array('Easy Configuring API','4.jpg'),
				  				5=>array('Build with JSON format','5.jpg'),
				  				6=>array('Control Log Access','6.jpg')
				  				)
				);
	return $data;
}

function slide_home_css(){
	$source = slide_home();
	$path = $source['path'];
	$data = $source['data'];
	$total_data = count($data);
	
	for($i=0;$i<$total_data;$i++){
		echo '
		.cb-slideshow li:nth-child('.($i+1).') span { 
		    background-image: url('.$path.'/'.$data[$i+1][1].');
		';

		if($i+1 !== 1){
		echo '
		    -webkit-animation-delay: '.($total_data*$i).'s;
		    -moz-animation-delay: '.($total_data*$i).'s;
		    -o-animation-delay: '.($total_data*$i).'s;
		    -ms-animation-delay: '.($total_data*$i).'s;
		    animation-delay: '.($total_data*$i).'s;
		';
		}

		echo '}'."\n";

		if($i+1 !== 1){
		echo '
			.cb-slideshow li:nth-child('.($i+1).') div { 
			    -webkit-animation-delay: '.($total_data*$i).'s;
			    -moz-animation-delay: '.($total_data*$i).'s;
			    -o-animation-delay: '.($total_data*$i).'s;
			    -ms-animation-delay: '.($total_data*$i).'s;
			    animation-delay: '.($total_data*$i).'s;
			}
		'."\n";
		}
	}
}

function get_template_php($file='',$name='',$delimiter='-',$redir=false,$ext='.php'){
	if($file!='' && $name!=''){
		$full_file_name = BASEDIR.'/'.$file.$delimiter.$name.$ext;
		if(file_exists($full_file_name))
		{
			include($full_file_name);
		}
		else{
			return $redir == false ? null : redir(site_url('page=error&msg=404'));
		}
	}
}

function load_error_template($headinfo=true,$header=true,$footer=false){
	if($headinfo==true){
		header("HTTP/1.0 400 Bad Request");
	}

	if($header==true){
		get_header(false,true);
	}

	get_template_php('inc/template','error');

	if($footer==true){
		get_footer();
	}
}

function verify_account($args=null){
	global $Users;

	if($args !== null){

		$data = base64_decode($args);

		if($data){

			preg_match_all('/[\;]/i', $data, $found_delimiter);
			if(count($found_delimiter[0]) == 2){

				$data = explode(';', $data);
				$usn = $data[0];
				$pas = $data[1];
				$vld = $data[2];

				$UserService = new User_Service($usn,$pas,null);
				$check_user = $UserService->check_user_exist();

				if($check_user !== null){

					$user_db = $check_user->fetch_array();
					$user_valid = $user_db['user_valid_cache'];

					if( $user_valid != '' AND $user_valid != 0 AND $vld == $user_valid){

						$prm = array('user_valid_cache'=>0,'user_status'=>'Y');
						$data = array('id'=>$user_db['user_id'],'prm'=>$prm);
						$update_valid = $Users->update_user_db($data);

						if($update_valid){
							redir(site_url('users'));
						}
						else{
							redir(site_url('?page=error&msg=400'));
						}

					}
					else{
						redir(site_url('?page=error&msg=406'));
					}

				}
				else{
					redir(site_url('?page=error&msg=401'));
				}

			}
			else{
				redir(site_url('?page=error&msg=422'));
			}

		}
		else{
			redir(site_url('?page=error&msg=422'));
		}
	}

	else{
		redir(site_url('?page=error&msg=404'));
	}
}

function to_link($url='',$text='',$target='_blank',$title=''){
	return '<a href="'.$url.'" target="'.$target.'" '.($title ? $title : $text).'>'.$text.'</a>';
}

function slugging($s){
	$s = preg_replace('/[\/\?\._ ]/','-',$s);
	$s = strtolower($s);
	return $s;
}
?>