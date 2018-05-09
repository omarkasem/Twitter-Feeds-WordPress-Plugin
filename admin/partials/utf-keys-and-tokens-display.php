<h4>You can get these information from <a target="_blank" href="https://apps.twitter.com/">Twitter Apps</a></h4>
<form method="post" action="options.php">
	<?php
		settings_fields( 'utf_options_group' );
		do_settings_sections( 'utf_options_group' );
	?>
	<table class="form-table">
		<tbody>

			<tr>
			<th scope="row"><label for="utf_consumer_key"><?php _e('Consumer Key',$this->plugin_name); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="utf_consumer_key" value="<?php echo sanitize_text_field(get_option('utf_consumer_key')); ?>">
				</td>
			</tr>

			<tr>
			<th scope="row"><label for="utf_consumer_secret"><?php _e('Consumer Secret',$this->plugin_name); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="utf_consumer_secret" value="<?php echo sanitize_text_field(get_option('utf_consumer_secret')); ?>">
				</td>
			</tr>

			<tr>
			<th scope="row"><label for="utf_access_token"><?php _e('Access Token',$this->plugin_name); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="utf_access_token" value="<?php echo sanitize_text_field(get_option('utf_access_token')); ?>">
				</td>
			</tr>

			<tr>
			<th scope="row"><label for="utf_access_token_secret"><?php _e('Access Token Secret',$this->plugin_name); ?></label></th>
				<td>
					<input type="text" class="regular-text" name="utf_access_token_secret" value="<?php echo sanitize_text_field(get_option('utf_access_token_secret')); ?>">
				</td>
			</tr>
		</tbody>
	</table>

	<?php submit_button(); ?>
</form>