<?php
/**
 * @since v.1.0
 * statusCode()
 * Membuat standar code response untuk ajax JSON
 * Diambil dari twitter API kemudian dibuat Class custom di sini
 * @return $status
 */ 
function statusCode($code='',$lang='id'){
	switch ($code){
		case 200:
			$status = $lang == 'id' ? 'Berhasil' : 'Successfull';
			break;
		case 201:
			$status = $lang == 'id' ? 'Sumber Berhasil Dibuat' : 'Resource created';
			break;
		case 202:
			$status = $lang == 'id' ? 'Proses Diterima' : 'Accepted for processing';
			break;
		case 301:
			$status =  $lang == 'id' ? 'Dialihkan' : 'Redirect';
			break;
		case 302:
			$status =  $lang == 'id' ? 'Ditemukan' : 'Found';
			break;
		case 304:
			$status =  $lang == 'id' ? 'Tidak Ada Data' : 'No Data';
			break;
		case 400:
			$status =  $lang == 'id' ? 'Permintaan Gagal' : 'Failed Request';
			break;
		case 401:
			$status =  $lang == 'id' ? 'Tidak Bisa di Otorisasi' : 'Authentication Failed';
			break;
		case 403:
			$status =  $lang == 'id' ? 'Masuk Kawasan Terlarang' : 'Forbidden';
			break;
		case 404:
			$status =  $lang == 'id' ? 'Tidak Tersedia' : 'No Exists';
			break;
		case 406:
			$status =  $lang == 'id' ? 'Akses Ditolak' : 'Access Denied';
			break;
		case 410:
			$status =  $lang == 'id' ? 'Permintaan Hilang' : 'Request Lost';
			break;
		case 420:
			$status =  $lang == 'id' ? 'Jangan Tergesa-gesa' : 'Do not rush';
			break;
		case 422:
			$status =  $lang == 'id' ? 'Data Tidak Diproses' : 'Can\'t process data';
			break;
		case 429:
			$status =  $lang == 'id' ? 'Terlalu Banyak Permintaan' : 'Too much requests';
			break;
		case 500:
			$status =  $lang == 'id' ? 'Server Bermasalah' : 'Disruption server';
			break;
		case 502:
			$status =  $lang == 'id' ? 'Salah Saluran' : 'Wrong way';
			break;
		case 503:
			$status =  $lang == 'id' ? 'Layanan Tidak Tersedia' : 'Undefined Services';
			break;
		case 504:
			$status =  $lang == 'id' ? 'Tenggang Saluran Habis' : 'Timeout requests';
			break;
		
		default:
			$status =  $lang == 'id' ? 'Malfungsi' : 'Cheating!';
			break;
	}
	return $status;
}

function status_array($code='', $lang='id'){
	if($code!=''){
		return array('status'=>$code,'message'=>statusCode($code,$lang),'key'=>null);
	}
	else{
		return array('status'=>404,'message'=>statusCode(404,$lang),'key'=>null);
	}
}
?>