<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

//$ue = base64_encode('admin@ofanebob.com');
//setcookie('ue',$ue,time() + (86400 * 1));

if(isset($_COOKIE['ue'])): 

$cookie_decode = base64_decode($_COOKIE['ue']);
$cookie_decode = explode('|',$cookie_decode);
$mail_cookie = $cookie_decode[0];
$name_cookie = $cookie_decode[1];

?>

<div class="container clearfix">

	<div class="row">

		<div class="col-lg-pull-2 col-lg-8 col-lg-push-2">

			<div class="form_access">

<?php

if(isset($_POST['push']) AND $_POST['push'] == 1){
	$data = array('email'=>$mail_cookie,'name'=>$name_cookie,'sender'=>email_author());
	$SendEmail = new SendEmail($data);
	$activate_account = $SendEmail->activate_account();

	if($activate_account == 200){
		get_global_alert(200);
	}
	else{
		redir(site_url('404'));
	}
}

?>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="nomargin">
							<i class="glyphicon glyphicon-ok"></i>
							Your API Data Created
						</h3>
					</div>

					<div class="panel-body">
						<h4>Thank you, <?= $name_cookie ?></h4>
						<p>Your data has been created, please check your email for verification.<br />
						Valid e-mail link for 3x24 hours.</p>
						<p>Re-send verify link to your email if not found on your inbox:</p>
						<form action="<?= site_url('users/success') ?>" method="POST">
							<div class="form-group row">

								<div class="col-lg-8">
								    <div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-envelope"></span>
										</span>
										<input value="<?= $mail_cookie ?>" type="email" name="reactive_email" class="input form-control" placeholder="Insert Your Email" disabled>
									</div>
								</div>

								<div class="col-lg-4">
								    <div class="input-group">
										<input type="hidden" name="push" value="1" />
										<input type="submit" value="Re-Send" class="btn btn-primary">
									</div>
								</div>

							</div>
					</div>
					<div class="panel-footer">
						<div class="text-right">
							<small class="text-gray"></small>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>

</div>

<?php
//
else:
//
redir(site_url('?page=error&msg=404'));
//
endif;
?>