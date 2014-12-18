<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Template User
 *
 * @author Ofan Ebob
 * @since v1.0
 */

global $Users;

if(isset($_GET['edit']) AND $_GET['edit'] == 'user' AND isset($_GET['id'])):

get_template_php('inc/template','edit-user');

else:

$user_db = Access_CRUD($Users->access_user_db(),'read');

?>

<div class="page-header row">
	<h1 class="col-lg-8">
	<i class="glyphicon glyphicon-user v-align-top"></i>
		Registered Users List</h1>
	<div class="col-lg-4 text-right">
		<a href="<?= site_url('ebob/add/user') ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>
			Add New User</a>
	</div>
</div>

<div class="spearator">
	
	<div class="row">

		<div class="col-lg-3">
			<?php get_template_php('inc/template','menu') ?>
		</div>
		<div class="col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="nomargin">List Users
						<small class="important label label-danger v-align-top">
							<?= $user_db->num_rows ?>
						</small>
					</h4>
				</div>
				<table class="table table-bordered">
					<tbody>
						<tr class="bg-info text-info">
							<th class="text-center">ID</th>
							<th class="text-center">Full Name</th>
							<th class="text-center">User Name</th>
							<th class="text-center">User Email</th>
							<th class="text-center" colspan="2">User Status</th>
						</tr>

						<?php
						while($user = $user_db->fetch_assoc()):

							if($user['user_id'] > 1):

							$active_class = $user['user_status'] == 'Y' ? 'text-danger bg-danger' : 'text-gray bg-white';
						?>

						<tr class="<?= $active_class ?>">
							<td><?= $user['user_id'] ?></td>
							<td><?= $user['user_firstname'] ?></td>
							<td><?= $user['user_name'] ?></td>
							<td><?= $user['user_email'] ?></td>
							<td><?= get_api_status($user['user_status'],true,true) ?></td>
							<td>
								<a href="<?= site_url('ebob/edit/user/'.$user['user_id']).'/drop' ?>" class="text-danger">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
								&nbsp;
								<a href="<?= site_url('ebob/edit/user/'.$user['user_id']) ?>">
									<i class="glyphicon glyphicon-pencil"></i>
								</a>
							</td>
						</tr>

						<?php
							endif;

						endwhile;
						?>
					</tbody>
				</table>
			</div>
		</div>

	</div>

</div>

<?php endif; ?>