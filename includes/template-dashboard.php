<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

global $Users, $apiuserlog_session, $userid_session;

get_logout_process();

?>

<div class="page-header row">
	<h1 class="col-lg-8">Data <?= $Users->get_userlog_full_name($apiuserlog_session) ?></h1>
	<div class="col-lg-4 text-right">
		<a class="btn btn-danger" href="<?= site_url('users?edit') ?>"><i class="glyphicon glyphicon-pencil"></i> Edit Account</a>
	</div>
</div>

<div class="panel panel-default">

	<div class="panel-heading">
		<h4 class="nomargin text-uppercase">Your Detail API</h4>
	</div>

	<table class="table table-bordered">
		<tbody>
			<tr>
				<th class="text-center bg-warning">Init</th>
				<th class="text-center bg-warning">Content / Value</th>
			</tr>

			<?php
			
			$user_api_db = get_api_data_by_user($userid_session);
			//echo json_encode($user_api_db);

			$api_id = isset($user_api_db['api_id']) ? $user_api_db['api_id'] : 'unaviable';
			$api_value = $user_api_db['api_status']=='Y' ? base64_encode(get_masterdata_format().'|'.$user_api_db['api_id'].'|'.strtotime($user_api_db['api_valid'])) : 'unaviable';
			$api_client = isset($user_api_db['api_client']) ? $user_api_db['api_client'] : 'unaviable';
			$api_valid = $user_api_db['api_status']=='Y' ? convert_date($user_api_db['api_valid']) : 'unaviable';
			$api_domain = isset($user_api_db['api_domain']) ? $user_api_db['api_domain'] : 'unaviable';
			$td_class = $user_api_db['api_status'] == 'Y' ? 'text-danger' : 'text-gray';
			$user_meta_array = array(
									 'ID'=>$api_id,
									 'VALUE'=>$api_value,
									 'DOMAIN'=>$api_domain,
									 'TYPE'=>$api_client,
									 'VALID'=>$api_valid,
									 'STATUS'=>get_api_status($user_api_db['api_status'],true,true)
									 );
			foreach($user_meta_array as $k => $v):
			?>

				<tr>
					<td width="100" align="right" class="text-gray"><?= $k ?>:</td>
					<td class="<?= $td_class ?> break-word-all"><?= $v ?></td>
				</tr>

			<?php
			endforeach;
			?>

		</tbody>
	</table>

</div>

<div class="panel panel-default">

	<div class="panel-heading">
		<h4 class="nomargin text-uppercase">API URL &amp; PARAMETER</h4>
	</div>

	<table class="table table-bordered">
		<tbody>
			<tr>
				<th class="text-center bg-warning">Name</th>
				<th class="text-center bg-warning">Info</th>
			</tr>


			<?php
			$uri_api = site_url('v1?ids='.$user_api_db['api_id'].'&lang=id');
			$url_api = site_url('v1/id/'.$user_api_db['api_id'].'.json');
			$download_api = site_url('v1/download/id/'.$user_api_db['api_id'].'.json');
			$api_param = array(	'ids'=>'API ID for registered user',
								'lang'=>'Language use (available for id & en)',
								'parameter'=>$user_api_db['api_status']=='Y' ? to_link( $uri_api, $uri_api, '_blank', 'Your Parameter' ) : 'unaviable',
								'pretty URL'=>$user_api_db['api_status']=='Y' ? to_link( $url_api, $url_api, '_blank', 'Your Parameter' ) : 'unaviable',
								'Download'=>$user_api_db['api_status']=='Y' ? to_link( $download_api, $download_api, '_blank', 'Download API' ) : 'unaviable'
							);

			foreach($api_param as $k => $v):
			?>

				<tr>
					<td width="100" align="right" class="text-gray"><?= $k ?>:</td>
					<td class="<?= $td_class ?> break-word-all"><?= $v ?></td>
				</tr>

			<?php
			endforeach;
			?>

		</tbody>
	</table>

</div>

<div class="separator"></div>