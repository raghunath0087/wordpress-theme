<?php
function ve_add_custom_user_profile_fields( $user ) {
?>
	<h3><?php _e('Extra Profile Information', 'virtualemployee'); ?></h3>
	
	<table class="form-table">
		<tr>
			<th>
				<label for="address"><?php _e('Profile Image', 'virtualemployee'); ?>
			</label></th>
			<td>
				<input type="text" name="user_pic" id="user_pic" value="<?php echo esc_attr( get_the_author_meta( 'user_pic', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter user profile pic path.', 'virtualemployee'); ?></span>
			</td>
		</tr>
	</table>
<?php }

function ve_save_custom_user_profile_fields( $user_id ) {
	
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	
	update_usermeta( $user_id, 'user_pic', $_POST['user_pic'] );
}

add_action( 'show_user_profile', 've_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 've_add_custom_user_profile_fields' );

add_action( 'personal_options_update', 've_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 've_save_custom_user_profile_fields' );
