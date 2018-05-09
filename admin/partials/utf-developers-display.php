<div class="utf-col-<?php if(is_rtl()){echo 'right';}else{echo 'left';} ?>">
<form method="post" action="" id="utf_url_form">
	<table class="form-table">
		<tbody>

			<tr>
			<th scope="row"><label for="utf_type_of_feed"><?php _e('Type of the feed',$this->plugin_name); ?></label></th>
				<td>
					<select name="utf_type_of_feed" class="utf_type_of_feed">
						<option value=""><?php _e('Types',$this->plugin_name); ?></option>
						<option value="by_name"><?php _e('By Username',$this->plugin_name); ?></option>
						<option value="by_search"><?php _e('By Search',$this->plugin_name); ?></option>
					</select>
				</td>
			</tr>
			
			<tfoot id="div_by_name" style="display: none;">
				<tr>
				<th scope="row"><label for="utf_username"><?php _e('Twitter name without @',$this->plugin_name); ?></label></th>
					<td>
						<input  type="text" id="utf_username">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_tweets_number"><?php _e('Number of Tweets',$this->plugin_name); ?></label></th>
					<td>
						<input value="5" type="number" id="utf_tweets_number">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_replies"><?php _e('Inlude Retweets ?',$this->plugin_name); ?></label></th>
					<td>
						<input type="checkbox" id="utf_replies" value="yes">
					</td>
				</tr>


			</tfoot>

			<tfoot id="div_by_search" style="display: none;">
				<tr>
				<th scope="row"><label for="utf_search_term"><?php _e('Included Search terms',$this->plugin_name); ?></label></th>
					<td>
						<input type="text" id="utf_search_term">
					</td>
				</tr>
				<tr>
				<th scope="row"><label for="utf_relation"><?php _e('Relation between terms ?',$this->plugin_name); ?></label></th>
					<td>
						<select id="utf_relation">
							<option value="and">Contain all terms</option>
							<option value="or">Contain any of the terms</option>
							<option value="exact">Exact Phrase</option>
						</select>
					</td>
				</tr>
				<tr>
				<th scope="row"><label for="utf_search_term_ex"><?php _e('Excluded Search terms (comma seperated)',$this->plugin_name); ?></label></th>
					<td>
						<input type="text" id="utf_search_term_ex">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_safe_tweets"><?php _e('Safe Tweets ?',$this->plugin_name); ?></label></th>
					<td>
						<select id="utf_safe_tweets">
							<option value="yes">Safe</option>
							<option value="no">Not Safe</option>
						</select>
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_tweets_kind"><?php _e('Kind of Tweets ?',$this->plugin_name); ?></label></th>
					<td>
						<select id="utf_tweets_kind">
							<option value="">All</option>
							<option value="media">image or video</option>
							<option value="native_video">uploaded video, Amplify video, Periscope, or Vine.</option>
							<option value="periscope">Periscope video URL</option>
							<option value="vine">Vine video URL</option>
							<option value="images">links identified as photos, including third parties such as Instagram.</option>
							<option value="twimg"> a pic.twitter.com link representing one or more photos.</option>
							<option value="links">Tweet Linking to URL</option>
						</select>
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_tweets_search_number"><?php _e('Number of Tweets',$this->plugin_name); ?></label></th>
					<td>
						<input value="5" type="number" id="utf_tweets_search_number">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_result_type"><?php _e('Result Type ?',$this->plugin_name); ?></label></th>
					<td>
						<select id="utf_result_type">
							<option value="recent">Recent</option>
							<option value="popular">Popular</option>
						</select>
					</td>
				</tr>
				
				<tr>
				<th scope="row"><label for="utf_since"><?php _e('Since Date',$this->plugin_name); ?></label></th>
					<td>
						<input type="text" class="utf_since">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="utf_until"><?php _e('Until Date',$this->plugin_name); ?></label></th>
					<td>
						<input type="text" class="utf_until">
					</td>
				</tr>


			</tfoot>


		</tbody>
	</table>

	<a href="https://codecanyon.net/item/ultimate-twitter-feed-pro/19909481?ref=OmaR-K" style="display: none;" id="pro_version" class="button button-primary">Buy Pro Version</a>
	<input style="display: none;" type="submit" id="generate_button" class="button button-primary" value="<?php _e('Generate URLS',$this->plugin_name); ?>">
</form>
<h2><?php _e('Generated WP REST URLS',$this->plugin_name); ?></h2>
<div id="utf_urls_div">
	<?php
		if(isset($_POST['reset_urls']) && check_admin_referer( 'reset_urls_nonce') && current_user_can('manage_options')){
			delete_option('utf_urls');
		}
		$urls = get_option('utf_urls');
		$output = "";
		if($urls != "" && is_array($urls)){
			$urls = array_reverse($urls);
			$output .= "<ul>";
			foreach($urls as $url){
				$url = str_replace('\\','',$url);
				$output .= "<li><input type='text' disabled value='".esc_attr($url)."'/></li>";
			}
			$output .= "<ul>";
			echo $output; ?>
		<?php } ?>
</div>
<?php if($urls != "" && is_array($urls)){ ?>
<form action="" method="post">
	<?php wp_nonce_field( 'reset_urls_nonce'); ?>
	<input type="submit" class="button button-primary" value="<?php _e('Reset URLS',$this->plugin_name); ?>" name="reset_urls">
</form>
<?php } ?>
</div>
<div class="utf-col-<?php if(!is_rtl()){echo 'right';}else{echo 'left';} ?>">
	<div class="card pressthis">
		<h2>Important Information:</h2>
		<h4>If you already have a ready designed HTML Twitter Feed Template, This is really going to help you as a devloper.
		You can use the WP Rest API to generate tweets and output them in any style you want. <br><br>
		Here's an example: </h4>
		<p class="utf_code">$generated_url = "http://example.com/?rest_route=/utf/utf_by_name/twitter/10/yes/";  <br>
		$json = file_get_contents($generated_url); <br>
		$tweets = json_decode($json); <br>
		foreach($tweets as $tweet){ <br>
			echo $tweet->name; <br>
		}
		</p>
		<hr>
		<h2>Examples about Relations:</h2>
		<h4>Example 1</h4>
		<p>
			Terms Included: wordpress plugins <br>
			Relation : Contain all terms<br>
			Result will be tweets containing both “wordpress” and “plugins”.
		</p>
		<hr>
		<h4>Example 2</h4>
		<p>
			Terms Included: Wordpress plugins <br>
			Relation : Contain any of the terms<br>
			Result will be tweets containing either “wordpress” or “plugins” (or both).
		</p>
		<hr>
		<h4>Example 3</h4>
		<p>
			Terms Included: Wordpress plugins <br>
			Relation : Exact Phrase<br>
			Result will be tweets containing the exact phrase “wordpress plugins”.
		</p>
		<hr>
		<h2>Safe Tweets ?</h2>
		<p>Tweets marked as potentially sensitive removed.</p>
		<hr>
		<h2>Since and Until Dates not working ?!</h2>
		<p>The twitter api only has a search index of a 7-day limit, In other words, no tweets will be found for a date older than one week.</p>
	</div>
</div>