<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

function get_site_options($table=''){
    $data = array(  'tbl'=>'*',
                    'from'=>'site_opt',
                    'prm'=>"WHERE opt_name='{$table}'"
                 );

    $site_opt = auto_fetch_db($data,'read');
    return $site_opt['opt_value'];
}

function site_url($url=''){
    $siteurl = get_site_options('siteurl');
    return $siteurl.(empty($url) ? '' : (preg_match('/(^\/)/',$url) ? $url : '/'.$url));
}

function api_version(){
    return get_author('api_version');
}

function site_title(){
    return get_site_options('title_web');
}

function get_author($request='author'){
    return get_site_options($request);
}

function author_name(){
    return get_author('author');
}

function url_author(){
    return get_author('url_author');
}

function email_author(){
    return get_author('email_author');
}

function get_masterdata_format(){
    return author_name().'|'.url_author().'|'.email_author();
}
?>