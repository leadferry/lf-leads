<?php
require( LEADFERRY_PATH . 'leads/classes/class-lf-event-list-table.php' );

$user_id = isset( $_GET['user_id'] ) ? $_GET['user_id'] : get_current_user_id();
$user_info = get_userdata( $user_id );
// Render the template
?>
<div class="wrap">
	<h1><?php echo $user_info->first_name . ' ' . $user_info->last_name; ?><a class ="page-title-action" href="<?php echo get_edit_user_link( $user_id ); ?>">Edit Profile</a></h1>
	<div class="card">
		<h3 class="title">Basic Info</h3>
		<p><strong>Email : </strong> <?php echo $user_info->user_email ; ?></p>
		<p><strong>First Visit : </strong> 01/11/2015 </p>
		<p><strong>Last Seen : </strong> 02/11/2015 </p>
	</div>	
	<?php
		$events_table = new LF_Event_List_Table();
		$events_table->prepare_items();
		$events_table->display();
	?>
</div><!-- end of wrap -->