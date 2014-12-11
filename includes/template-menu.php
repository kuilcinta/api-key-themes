<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

$menu_data = array(	'api'=>'Lists API|glyphicon glyphicon-list-alt',
					'user'=>'Lists Users|glyphicon glyphicon-user',
					'setting'=>'Web Setting|glyphicon glyphicon-wrench'
					);

$api_data_inactive = Access_CRUD(get_api_data_db(array('where'=>"api_status='N'")),'read');
$api_inactive_count = $api_data_inactive->num_rows;

?>

<div class="panel panel-default">

	<div class="panel-heading">
		<h4 class="nomargin">Main Menu</h4>
	</div>

	<div class="list-group">

		<?php
		foreach($menu_data as $slug => $name){
			$active = ((isset($_GET['data']) AND $_GET['data'] == $slug) OR ($slug == 'api' AND empty($_GET['data']))) ? ' active' : '';
			$url = $slug == 'api' ? 'ebob' : 'ebob/'.$slug;
			$name = explode('|', $name);

			$popover = '';
			$notif = '';
			if($slug == 'api'){
				if($api_inactive_count > 0){
				$popover .= 'title="Notification" id="popover" data-content="You have '.$api_inactive_count.', moderating API" data-toggle="popover" data-trigger="hover" data-container="body"';
				$notif = '<span class="badge">'.$api_inactive_count.'</span>';
				}
			}

			echo '<a href="'.site_url($url).'" class="list-group-item '.$active.'" '.$popover.' >';
			echo '<i class="'.$name[1].'"></i> '.$name[0];
			echo $notif;
			echo '</a>';
		}
		?>
	</div>

</div>