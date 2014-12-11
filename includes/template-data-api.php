<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template Data API
 *
 * @author Ofan Ebob
 * @since v1.0
 */
global $Users;

if(isset($_GET['edit']) AND $_GET['edit'] == 'api' AND isset($_GET['id'])):

	get_template_php('includes/template','edit-api');

elseif(isset($_GET['add']) AND $_GET['add'] == 'api'):

	get_template_php('includes/template','add-api');

else:

$data = array('order'=>'api_data.api_valid');

$vars = isset($_GET['var']) ? $_GET['var'] : null;

$data['where'] = $vars !== null ? "api_data.api_status='$vars'" : null;

$api_data = Access_CRUD(get_api_user_merge_db($data),'read');

?>
<div class="page-header row">
	<h1 class="col-lg-8"><i class="glyphicon glyphicon-list-alt v-align-top"></i>
		All API Data Lists</h1>
	<div class="col-lg-4 text-right">
		<a href="<?= site_url('ebob/add/api') ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>
			Add New API</a>
	</div>
</div>

<div class="spearator">

	<div class="row">
		<div class="col-lg-3">
			<?php get_template_php('includes/template','menu') ?>
		</div>
		<div class="col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="nomargin">List APi Data
						<small class="important label label-danger v-align-top">
							<?= $api_data->num_rows ?>
						</small>
					</h4>
				</div>
				<table class="table table-bordered">
					<tbody>

						<?php
						if($api_data->num_rows > 0):
						?>

						<tr class="bg-info text-info">
							<th class="text-center">API User</th>
							<th class="text-center">API ID</th>
							<th class="text-center">API Valid</th>
							<th class="text-center" colspan="2">API Status</th>
						</tr>

						<?php
						while($api = $api_data->fetch_assoc()):
							$api_status = $api['api_status'];
							$active_class = $api_status == 'Y' ? 'text-danger bg-danger' : ($api_status == 'N' ? 'text-warning bg-warning' : 'text-gray bg-white');
						?>
						<tr class="<?= $active_class ?>">
							<td>
								<a class="color-auto important" href="<?= site_url('ebob/edit/user/'.$api['user_id']) ?>">
									<strong><?= $api['user_name'] ?></strong>
								</a>
							</td>
							<td><?= $api['api_id'] ?></td>
							<td><?= convert_date($api['api_valid']) ?></td>
							<td><?= get_api_status($api['api_status'],true,true) ?></td>
							<td>
								<a href="<?= site_url('ebob/edit/api/drop/0/id/'.$api['api_index']) ?>" class="text-danger">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
								&nbsp;
								<a href="<?= site_url('ebob/edit/api/'.$api['api_index']) ?>">
									<i class="glyphicon glyphicon-pencil"></i>
								</a>
							</td>
						</tr>

						<?php
						endwhile;

						else:
							echo alert_markup(array('type'=>'warning nomargin','msg'=>'No data found'));
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<?php endif; ?>