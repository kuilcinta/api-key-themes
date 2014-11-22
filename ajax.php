<?php
/**
 * @author ofanebob
 * @copyright 2014
 * Fungsi AJAX Port
 * Penyederhanaan code dengan mengganti beberapa fungsi standar kedalam fungsi complex dari lib PHP
 * Fungsi dasar berasal dari project ticket tracker (2013) yang dimodifikasi dari kode wordpress
 * Kemudian di tambahkan beberapa fungsi error handler dan dynamic return untuk format response
 * -----------------------------------------------------------------------------------------------------
 * Standar penggunaan file ajax.php harus dengan jQuery
 * Beberapa parameter yang menjadi rumus baku adalah:
 * cls >>> NAMA CLASS
 * fn >>> NAMA FUNCTION
 * err >>> STATUS TIMEOUT UNTUK DOM ERROR
 * prm >>> NILAI parameter HARUS ARRAY >>> serializeArray() atau toArray['']
 */
 
require_once('config.php');

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){

@header( 'Content-Type: text/html; charset=utf-8');
@header( 'X-Robots-Tag: noindex' );

nocache_headers();
    
    function return_format($response,$return,$tojson=true){

        /* PENTING!
         * Pengaturan ifelse condition berisi nilai boolean
         * Untuk menyatakan apakah output akan menggunakan format JSON atau TEXT pada AJAX respons
         */
        if($tojson==true){
            echo json_encode($return);
        }
        else{
            echo $response;
        }
        exit(); 

    }


    /**
     * @since v.1.0
     * Menangani AJAX Proses tahap ketiga setelah ajax_process
     * Lebih mendetail karena akan memisahkan nilai dari parameter sesuai kebutuhan
     * Yaitu memisahkan nama Class, nama Function dan isi/nila Parameter fungsi berupa data Array()
     * Kemudian akan di kirim ke fungsi return_format() jika berhasil
     * atau dikirim ke fungsi ajaxError() jika gagal
     */
    function ajax_response_handler($method,$a_parms,$timeout,$tojson){

        /* Cek ketersediaan nama Class */
        if(class_exists($method[0])){

            /* Cek apakah fungsi di dalam Class bisa digunakan & dipanggil dengan fungsi lain */
            if(method_exists($method[0], $method[1]) && is_callable(array($method[0], $method[1]))) {

                /* Menggunakan call_user_func_array untuk memanggil fungsi dalam Class beserta parameter yg dibutuhkan
                 * Nama Class dan Function masuk kedalam array()
                 * Parameter Function masuk kedalam array, variable $a_params adalah hasil pengolahan dari array_push()
                 */
                $response = call_user_func_array(array($method[0], $method[1]), $a_parms);

                if(is_array($response)){
                    $return = $response;
                    return return_format($response,$return,$tojson);
                }
                else{
                    $return = array('status'=>200,'data'=>$response);
                    return return_format($response,$return,$tojson);
                }

            }
            else {
                $response = ajaxError($method[1],false,$timeout,'warning',true,false);
                $return = array('status'=>400,'data'=>$response);
                return return_format($response,$return,$tojson);
            }
        }
        else {
            /* Fungsi untuk memeriksa ketersediaan function tanpa Class */
            if(function_exists($method[1])){
                $response = call_user_func_array($method[1], $a_parms);

                if(is_array($response)){
                    $return = $response;
                    return return_format($response,$return,$tojson);
                }
                else{
                    $return = array('status'=>200,'data'=>$response);
                    return return_format($response,$return,$tojson);
                }

            }
            /* Jika Function tidak ada maka respon akan dikirm ke ajaxError() */
            else{
                $response = ajaxError($method[1],false,$timeout,'warning',true,false);
                $return = array('status'=>400,'data'=>$response);
                return return_format($response,$return,$tojson);
            }
        }
    }


    /**
     * @since v.1.0
     * Menangani AJAX Proses tahap kedua setelah GLOBAL Method
     * Kemudian akan di kirim ke fungsi ajax_response_handler() jika berhasil
     * atau dikirim ke fungsi ajaxError() jika gagal
     */
    function ajax_process($class,$function,$timeout,$params){

        /* Menetapkan variable $method berdasakan isi dari variable $class
         * Jika nilai pada variable $class kosong maka array() index pertama berisi string kosong 
         */
        if(empty($class)){
            $method = array('',$function);
        }
        else{
            /* Jika nilai varibale $class tidak kosong maka array() index 1 berisi nilai $class & index 2 berisi $function */
            $method = array($class,$function);
        }

        /* isi dari parameter variable $params adalah harus berupa array
         * Jika nilai $params bukan array maka output AJAX adalah error
         */
        if(is_array($params)){

            /* Push Array untuk memecah serializeArray() hasil dari jQuery AJAX
             * Pola awal serializeArray() adalah array( [0] => array('name'=>'a','value'=>'b') )
             * Dirubah menjadi array('a','b')
             */
            $a_parms = array();
            $n_parms = count($params);
            for($a=0;$a<$n_parms;$a++){

                if($params[$a]['value']){
                    array_push($a_parms, strip_tags(br2nl($params[$a]['value']), '<b><strong><i><em><strike><center><span>'));
                }
                else{
                    return ajaxError($function,304,$timeout,'warning',true,true);
                    break;
                }
            }

            $response = ajax_response_handler($method,$a_parms,$timeout,true);

        }
        /* Menangani URL parameter pada AJAX Request untuk fungsi load() pada jQuery
         * nilai parameter pada indeks prm harus didefinisikan menggunakan toArray[''] terlebih dahulu
         * contoh: cl=Class&fn=Function&err=1&prm=toArray['isi1','isi2','etc']
         */
        elseif(preg_match('/[Tt]o[Aa]rray\[(.*)\]/', $params, $matches)){
            $params_value = strip_tags(br2nl($matches[1]), '<b><strong><i><em><strike><center><span>');
            if(strpos($params_value,',')){
                $a_parms = explode(',', $params_value);
            }
            else{
                $a_parms = array($params_value);
            }
            $response = ajax_response_handler($method,$a_parms,$timeout,false);
        }
        else{
            $response = ajaxError($function,422,$timeout,'warning',true,true);
        }

        return $response;
    }


    /**
     * @since v.1.0
     * Global parameter GET/POST method for AJAX Request function
     * Semua parameter di metode form atau XHTTPS akan dikirm ke fungsi ajax_process()
     * Dengan parameter fungsi:
     * $class = untuk nama class
     * $function = untuk nama function
     * $timeout = untuk timout hide DOM pada response error
     * $params = data input/parameter ajax dalam bentuk array
     * Khusus method GET pada URL parameter AJAX, nilai $params harus didefinisikan menggunakan toArray['NILAI']
     */
    if(isset($_POST['cl']) AND isset($_POST['fn'])){
        $class = isset($_POST['cl']) ? $_POST['cl'] : '';
        $function = isset($_POST['fn']) ? $_POST['fn'] : '';
        $timeout = isset($_POST['err']) ? $_POST['err'] : '';
        $params = isset($_POST['prm']) ? $_POST['prm'] : '';
        return ajax_process($class,$function,$timeout,$params);
    }
    elseif(isset($_GET['cl']) AND isset($_GET['fn'])){
        $class = isset($_GET['cl']) ? $_GET['cl'] : '';
        $function = isset($_GET['fn']) ? $_GET['fn'] : '';
        $timeout = isset($_GET['err']) ? $_GET['err'] : '';
        $params = isset($_GET['prm']) ? $_GET['prm'] : '';
        return ajax_process($class,$function,$timeout,$params);
    }
    else{
        /* Jika tidak ada GLOBAL method POST/GET maka akan di alhikan ke redirError() */
        redirError(401);
    }
}
else{
    redirError(404);
}
?>