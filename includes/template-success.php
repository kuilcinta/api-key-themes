<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

if(isset($_COOKIE['ue'])): 

//$ue = base64_encode('your@email.domain');
//setcookie('ue',$ue,time() + (86400 * 7));

$mail_cookie = base64_decode($_COOKIE['ue']);

?>

<div class="container clearfix">

	<div class="row">

		<div class="col-lg-pull-2 col-lg-8 col-lg-push-2">

			<div class="panel panel-primary form_access">
				<div class="panel-heading">
					<h3 class="nomargin">
						<i class="glyphicon glyphicon-ok"></i> Success
					</h3>
				</div>

				<div class="panel-body">
					<p>Your data has been created, please check your email for account activation.<br />
					Valid e-mail link for 3x24 hours.</p>
					<p>Re-send activator link to your email if not found on your inbox:</p>
					<form action="<?= site_url('?resend=email') ?>" method="POST">
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

<?php
//
else:
//
redir(site_url('?page=error&msg=404'));
//
endif;
?>