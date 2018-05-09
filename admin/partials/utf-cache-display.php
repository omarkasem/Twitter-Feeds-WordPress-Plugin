<form method="post" action="" id="utf_cache_form">
	<table class="form-table">
		<tbody>

			<tr>
			<th scope="row"><label for="utf_cache_option"><?php _e('Enable Cache ?',$this->plugin_name); ?></label></th>
				<td>
					<input type="checkbox" class="regular-text utf_cache_option" name="utf_cache_option" <?php checked( sanitize_text_field(get_option('utf_cache_option')), 'on' ); ?> >
				</td>
			</tr>
			<tfoot class="utf_cache_div" <?php if(get_option('utf_cache_option') !== 'on'){echo 'style="display: none;"';} ?>>
				<tr>
				<th scope="row"><label for="utf_cache_in_minutes"><?php _e('Cache Time (in minutes)',$this->plugin_name); ?></label></th>
					<td>
						<input type="text" class="regular-text" name="utf_cache_in_minutes" value="<?php echo intval(get_option('utf_cache_in_minutes')); ?>">
					</td>
				</tr>
			</tfoot>


		</tbody>
	</table>

<p class="submit"><a href="https://codecanyon.net/item/ultimate-twitter-feed-pro/19909481" name="submit" id="submit" class="button button-primary">Buy Pro Version</a></p>
</form>