<div class="donorinfo donor-delete">
	<h3><?php esc_html_e('Do you want to delete?', 'idonate'); ?></h3>
	<p><?php esc_html_e('Name :', 'idonate'); ?> {{data.full_name}} </p>
	<p><?php esc_html_e('User Name:', 'idonate'); ?> {{data.user_name}}</p>
	<!-- Personal Info-->
	<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
		<?php
		wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
		?>
		<input type="hidden" name="user_id" value="{{data.id}}">
		<input type="hidden" name="action" value="donor_delete">
		<input class="idonate_button" type="submit" name="donor_delete" value="<?php esc_html_e('OK', 'idonate'); ?>">
		<input class="idonate_button" type="submit" name="donor_delete_no" value="<?php esc_html_e('No', 'idonate'); ?>">
	</form>
</div>