<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * SendMail class
 * Menangani permintaan pengiriman email
 * Melalui proses PHP Mailer
 *
 * @author Ofan Ebob
 * @since v1.0
 */

class SendEmail {

	protected $_args;
	protected $_sender;
	protected $_receiver;
	protected $_subject;
	protected $_message;
	protected $_files;

	public function __construct($args){
		$this->_args = $args ? $args : array();
	}

	public function activate_account(){
		$args = $this->_args;
		$this->_receiver = isset($args['email']) ? $args['email'] : null;
		$receiver = $this->_receiver;

		if($receiver !== null){

			$checkEmail = $this->_checkEmail();

			if($checkEmail !== null){
				$this->_sender = isset($args['sender']) ? $args['sender'] : '';
				$sender = $this->_sender;
				
				$this->_subject = 'Verify Account';

				$name_receiver = $args['name'];

				$message = 'Thank you '.$name_receiver.', for register your web API key to '.site_url().'.'."\n\r";
				$message .= 'Follow this link to verification: '."\n";
				$message .= site_url( 'verify/'.base64_encode($checkEmail['user_name'].';'.$checkEmail['user_pass'].';'.$checkEmail['user_valid_cache']) );

				$this->_message = $message;
				$this->_header = $name_receiver;
				//$header = $this->_header;
				$this->_files = null;

				file_put_contents(BASEDIR.'/test/verify.txt', $sender."\n".$receiver."\n".$message);
				return 200;
				
				/*$pushEmail = $this->_pushEmail();

				if($pushEmail !== null){
					return 200;
				}
				else {
					return 401;
				}*/
			}

		}
		else {
			return 406;
		}
	}

	protected function _checkEmail(){
		$receiver = $this->_receiver;

		$where = $receiver !== null ? "WHERE user_email='{$receiver}'" : '';

		$data = array('row'=>'*',
					  'tbl'=>'users',
					  'prm'=>$where
					  );

		$sql = Access_CRUD($data,'read');

		if($sql->num_rows == 0){
			return null;
		}
		else {
			return array_fetch_db($data,'read');
		}
	}
/*
	protected function _pushEmail(){
		$args = $this->_args;
		$sender = $this->_sender;
		$receiver = $this->_receiver;
		$subject = $this->_subject;
		$message = $this->_message;
		$files = $this->_files;
		$headers = "From: $sender";

		if(is_array($files)){
			// array with filenames to be sent as attachment
			$files = array("file_1.ext","file_2.ext","file_3.ext");
			 
			// boundary
			$semi_rand = md5(time());
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
			 
			// headers for attachment
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
			 
			// multipart boundary
			$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
			$message .= "--{$mime_boundary}\n";
			 
			// preparing attachments
			for($x=0;$x<count($files);$x++){
			    $file = fopen($files[$x],"rb");
			    $data = fread($file,filesize($files[$x]));
			    fclose($file);
			    $data = chunk_split(base64_encode($data));
			    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" .
			    "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" .
			    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			    $message .= "--{$mime_boundary}\n";
			}
		}
		 
		// send
		 
		$ok = @mail($receiver, $subject, $message, $headers);
		if ($ok) {
			return true;
		} else {
			return null;
		} 

	}

	public function email_html($args){

	}*/
}

?>