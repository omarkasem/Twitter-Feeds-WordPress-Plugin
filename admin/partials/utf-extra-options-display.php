<form method="post" action="" id="utf_ex_options_form">

	<table class="form-table">
		<tbody>

				
				<th class='utf_sub_title'>Main Tweet Options</th>

				<tr>
				<th scope="row"><label for="utf_date_of_tweet"><?php _e('Hide Date of tweet',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_date_of_tweet" name="utf_date_of_tweet" <?php checked( get_option('utf_date_of_tweet'), 'on' ); ?> >
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_replies_icon"><?php _e('Hide Replies Icon',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_replies_icon" name="utf_replies_icon" <?php checked( get_option('utf_replies_icon'), 'on' ); ?> >
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_retweets_icon"><?php _e('Hide Retweets Icon',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_retweets_icon" name="utf_retweets_icon" <?php checked( get_option('utf_retweets_icon'), 'on' ); ?> >
					</td>
				</tr>


				<tr>
				<th scope="row"><label for="utf_favorites_icon"><?php _e('Hide Favorites Icon',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_favorites_icon" name="utf_favorites_icon" <?php checked( get_option('utf_favorites_icon'), 'on' ); ?> >
					</td>
				</tr>

				<th class='utf_sub_title'>Videos</th>
				<tr>
				<th scope="row"><label for="utf_hide_videos"><?php _e('Hide Videos in Tweets',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_hide_videos" name="utf_hide_videos" <?php checked( get_option('utf_hide_videos'), 'on' ); ?> >
					</td>
				</tr>

				<th class='utf_sub_title'>Images</th>
				<tr>
				<th scope="row"><label for="utf_hide_images"><?php _e('Hide Images in Tweets',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" class="regular-text utf_hide_images" name="utf_hide_images" <?php checked( get_option('utf_hide_images'), 'on' ); ?> >
					</td>
				</tr>


				<tr>
				<th scope="row"><label for="utf_size_images"><?php _e('Size of Images',$this->plugin_name); ?></label></th>
					<td>
						<select name="utf_size_images">
							<option value="">Size</option>
							<option <?php if(get_option('utf_size_images') == 'thumbnail'){echo 'selected';} ?> value="thumbnail">Thumbnail</option>
							<option <?php if(get_option('utf_size_images') == 'medium'){echo 'selected';} ?> value="medium">Medium</option>
							<option <?php if(get_option('utf_size_images') == 'large'){echo 'selected';} ?> value="large">Large</option>
						</select>
					</td>
				</tr>


		</tbody>
	</table>

<p class="submit"><a href="https://codecanyon.net/item/ultimate-twitter-feed-pro/19909481" name="submit" id="submit" class="button button-primary">Buy Pro Version</a></p>
</form>