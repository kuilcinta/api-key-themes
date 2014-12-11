<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

$data = array('tbl'=>true,'prm'=>"ORDER BY opt_permanent DESC");

$Setting = new Setting($data);
$setting_db = $Setting->read_site_opt();

?>

<div class="page-header row">
	<h1 class="col-lg-8"><i class="glyphicon glyphicon-wrench v-align-top"></i>
		Setting Web</h1>
	<div class="col-lg-4 text-right">
		
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
					<h4 class="nomargin">Site Options & Setting
					</h4>
				</div>
				<table class="table table-bordered">
					<tbody>

						<?php
						if($setting_db->num_rows > 0):
						?>

						<tr class="bg-info text-info">
							<th class="text-center">Name Config</th>
							<th class="text-center">Value Config</th>
							<th class="text-center">Action</th>
						</tr>

						<?php while($opt = $setting_db->fetch_assoc()): ?>

						<tr>
							<td>
								<strong><?= $opt['opt_name'] ?></strong>
							</td>
							<td><?= truncate($opt['opt_value'],100,50) ?></td>
							<td>

								<?php if($opt['opt_permanent'] != 1): ?>
								<a href="<?= site_url('ebob?edit=setting&drop=0&id='.$opt['opt_id']) ?>" class="text-danger">
									<i class="glyphicon glyphicon-trash"></i>
								</a>
								<?php endif; ?>

								&nbsp;
								<a href="<?= site_url('ebob?edit=setting&id='.$opt['opt_id']) ?>">
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