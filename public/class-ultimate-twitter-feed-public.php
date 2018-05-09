<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       omark
 * @since      1.0.0
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/public
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Twitter_Feed_Public extends WP_Widget
{
    private $consumer_key;
    private $consumer_secret;
    private $access_token;
    private $access_token_secret;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name = '', $version = '')
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->consumer_key = get_option('utf_consumer_key');
        $this->consumer_secret = get_option('utf_consumer_secret');
        $this->access_token = get_option('utf_access_token');
        $this->access_token_secret = get_option('utf_access_token_secret');

        // BY NAME
        add_action('rest_api_init', function () {
            // by user
            register_rest_route('utf', '/utf_by_name/(?P<name>[a-zA-Z0-9-_]+)/(?P<number>\d+)/(?P<include_retweets>[a-zA-Z]+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'utf_get_tweets_by_user_in_json'),
            ));
        });


        parent::__construct(
            'utf_widget',
            __('Ultimate Twitter Feed', $this->plugin_name),
            array('description' => __('Ultimate Twitter Feed Widget', $this->plugin_name),)
        );
    }


    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ultimate_Twitter_Feed_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ultimate_Twitter_Feed_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('utf_awesome' . $this->plugin_name, plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');


        wp_enqueue_style('utf_public_' . $this->plugin_name, plugin_dir_url(__FILE__) . 'css/ultimate-twitter-feed-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ultimate_Twitter_Feed_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ultimate_Twitter_Feed_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('utf_public' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/ultimate-twitter-feed-public.js', array('jquery'), $this->version, false);

    }

    // Make a connetion to TwitterOAuth with the required credentials.
    private function utf_make_connection()
    {
        return new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret);
    }

    // Get tweets by user after creating a connection to TwitterOAuth.
    private function get_tweets_by_user($username, $number, $include_retweets = true)
    {
        $connection = $this->utf_make_connection();
        $tweets = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $username . '&count=' . $number . '&include_rts=' . $include_retweets . '&tweet_mode=extended');
        return $tweets;
    }


    // The twitter feed json array
    private function utf_json_array($tweets = array())
    {
        if ($this->consumer_key != "" && $this->consumer_secret != "" && $this->access_token != "" && $this->access_token_secret != "") {
            if (isset($tweets->statuses) && $tweets->statuses !== null) {
                $tweets = $tweets->statuses;
            }
            if (!empty($tweets) && is_array($tweets)) {
                foreach ($tweets as $tweet) {
                    $name = $tweet->user->name;
                    $screen_name = $tweet->user->screen_name;
                    $profile_link = "https://twitter.com/" . $screen_name;
                    $location = $tweet->user->location;
                    $desc = $tweet->user->description;
                    $id_str = $tweet->id_str;
                    $followers_count = $tweet->user->followers_count;
                    $image = $tweet->user->profile_image_url;
                    $time = $tweet->created_at;
                    $time = strtotime($time);
                    $human_time = human_time_diff($time, current_time('timestamp')) . " ago";
                    $text = $tweet->full_text;
                    $html_text = str_replace("\\", "/",$this->utf_tweet_to_html($tweet));
                    $retweet_count = $tweet->retweet_count;
                    $favorite_count = $tweet->favorite_count;
                    $array[] = (object)array(
                        'name' => $name,
                        'screen_name' => $screen_name,
                        'id_str' => $id_str,
                        'profile_link' => $profile_link,
                        'location' => $location,
                        'description' => $desc,
                        'tweet_text' => $text,
                        'tweet_text_html' => $html_text,
                        'time' => $human_time,
                        'image' => $image,
                        'retweet_count' => $retweet_count,
                        'favorite_count' => $favorite_count,
                        'followers_count' => $followers_count,
                    );
                }
                return $array;
            } else {
                return "Twitter account has no tweets !";
            }
        } else {
            return "Please fill all the keys and tokens fields !";
        }
    }

    // The twitter feed shortcode html v1
    private function utf_shortcode_html($tweets = array())
    {
        if ($this->consumer_key != "" && $this->consumer_secret != "" && $this->access_token != "" && $this->access_token_secret != "") {
            if (isset($tweets->statuses) && $tweets->statuses !== null) {
                $tweets = $tweets->statuses;
            }
            $output = "";
            if (!empty($tweets) && is_array($tweets)) {
                    foreach ($tweets as $tweet) {
                        $name = $tweet->user->name;
                        $screen_name = $tweet->user->screen_name;
                        $profile_link = "https://twitter.com/" . $screen_name;
                        $location = $tweet->user->location;
                        $desc = $tweet->user->description;
                        $id_str = $tweet->id_str;
                        $followers_count = $tweet->user->followers_count;
                        $image = $tweet->user->profile_image_url;
                        $time = $tweet->created_at;
                        $time = strtotime($time);
                        $human_time = human_time_diff($time, current_time('timestamp')) . " ago";
                        $text = $tweet->full_text;
                        $retweet_count = $tweet->retweet_count;
                        $favorite_count = $tweet->favorite_count;

                        $output .= "<div class='utf_tweet'>";
                        $output .= "<a class='utf_tweet_img' target='_blank' href='" . $profile_link . "'><img src='" . $image . "' alt='" . $name . "'></a>";
                        $output .= "<div class='utf_tweet_names'><h4>" . $name . "</h4>";
                        $output .= "<a target='_blank' href='" . $profile_link . "'>@" . $screen_name . "</a></div>";
                        $output .= "<p>" . $this->utf_tweet_to_html($tweet) . "</p>";

                        $output .= "<div class='utf_links'>";
                        $output .= "<span>" . $human_time . "</span>";
                        $output .= "<span><a target='_blank' href='https://twitter.com/intent/tweet?in_reply_to=" . $id_str . "'><i class='fa fa-mail-reply'></i></a></span>";
                        $output .= "<span><a target='_blank' href='https://twitter.com/intent/retweet?tweet_id=" . $id_str . "'><i class='fa fa-retweet'>" . $retweet_count . "</i></a></span>";
                        $output .= "<span><a target='_blank' href='https://twitter.com/intent/favorite?tweet_id=" . $id_str . "'><i class='fa fa-heart'>" . $favorite_count . "</i></a></span>";
                        $output .= "</div>";

                        $output .= "</div>";
                    }
                    return $output;


            } else {
                return "Twitter account has no tweets !";
            }
        } else {
            return "Please fill all the keys and tokens fields !";
        }
    }


    // Get tweets by user and making a shortcode so the user can use it easily.
    public function utf_shortcode_by_user($atts)
    {
        extract(shortcode_atts(array(
            'username' => '',
            'number' => '',
            'include_retweets' => '',
        ), $atts));
        if ($atts['include_retweets'] == "yes") {
            $include_retweets = true;
        } else {
            $include_retweets = false;
        }

        $tweets = $this->get_tweets_by_user($atts['username'], $atts['number'], $include_retweets);
        return $this->utf_shortcode_html($tweets);
    }

    // Converting the simple text tweet to HTML tweet with links on users and hashtags just like the site.
    private function utf_tweet_to_html($tweet)
    {
        $tweet_text = $tweet->full_text;
        //Convert urls to <a> links
        $tweet_text = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $tweet_text);

        //Convert hashtags to twitter searches in <a> links
        $tweet_text = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a target=\"_new\" href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweet_text);

        //Convert attags to twitter profiles in <a> links
        $tweet_text = preg_replace("/@([A-Za-z0-9_\/\.]*)/", "<a href=\"http://www.twitter.com/$1\">@$1</a>", $tweet_text);



        if(property_exists($tweet,'extended_entities')){

            if(property_exists($tweet->extended_entities,'media')){
                $videos = $tweet->extended_entities->media;
                  if(is_array($videos) && !empty($videos)){
                    foreach($videos as $video){
                        if($video->type == 'photo'){
                            $width = $video->sizes->medium->w;
                            $height = $video->sizes->medium->h;
                            $tweet_text .= "<a target='_blank' href='".$video->expanded_url."'><img class='utf_tweet_image' height='".$height."' width='".$width."' src='".$video->media_url."'></a>";
                        }

                    }
                }
            }
        }else{
                $tweet_text .= $this->utf_get_image_entity($tweet);
        }

        return $tweet_text;

    }

    private function utf_get_image_entity($tweet){
        $tweet_text = '';
        if(property_exists($tweet->entities,'media')){
          $all_media = $tweet->entities->media;
          if(is_array($all_media) && !empty($all_media)){
            foreach($all_media as $media){
                $width = $media->sizes->medium->w;
                $height = $media->sizes->medium->h;
                $tweet_text  .= "<a target='_blank' href='".$media->expanded_url."'><img class='utf_tweet_image' height='".$height."' width='".$width."' src='".$media->media_url."'></a>";
            }
          }
        }

        return $tweet_text;
    }



    // Get tweets by user using the WP REST API and retruning the important keys and values of the tweets to developers.
    public function utf_get_tweets_by_user_in_json($data)
    {
        if ($data['include_retweets'] == "yes") {
            $include_retweets = true;
        } else {
            $include_retweets = false;
        }

        $tweets = $this->get_tweets_by_user($data['name'], $data['number'], $include_retweets);

        return $this->utf_json_array($tweets);
    }


    // START WIDGET FUNCTIONS
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        if ($instance['type'] == 'by_name') {
            if ($instance['include_retweets'] == "on") {
                $include_retweets = true;
            } else {
                $include_retweets = false;
            }


            $tweets = $this->get_tweets_by_user($instance['username'], $instance['number'], $include_retweets);

            echo $this->utf_shortcode_html($tweets);
        }



        echo $args['after_widget'];
    }

    public function form($instance)
    {
        // Default
        $title = "";
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }

        $type = "";
        if (isset($instance['type'])) {
            $type = $instance['type'];
        }


        // By Name
        $username = "";
        if (isset($instance['username'])) {
            $username = $instance['username'];
        }
        $number = "";
        if (isset($instance['number'])) {
            $number = $instance['number'];
        }
        $include_retweets = "";
        if (isset($instance['include_retweets'])) {
            $include_retweets = $instance['include_retweets'];
        }
        ?>
        <!-- Default -->
        <div class="utf_widget_div">
            <p>
                <label
                    for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $this->plugin_name); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>"/>
            </p>
            <p>
                <label
                    for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type of Feed:', $this->plugin_name); ?></label>
                <select class="utf_widget_type_of_feed widefat" name="<?php echo $this->get_field_name('type'); ?>">
                    <option <?php if ($type == '') {
                        echo "selected";
                    } ?> value="">Types
                    </option>
                    <option <?php if ($type == 'by_name') {
                        echo "selected";
                    } ?> value="by_name">By Username
                    </option>
                    <option <?php if ($type == 'by_search') {
                        echo "selected";
                    } ?> value="by_search">By Search
                    </option>
                </select>
            </p>

            <!-- By Name -->
            <div class="utf_widget_by_name" <?php if ($type !== "by_name") {
                echo 'style="display: none;"';
            } ?>>
                <p>
                    <label
                        for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', $this->plugin_name); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>"
                           name="<?php echo $this->get_field_name('username'); ?>" type="text"
                           value="<?php echo esc_attr($username); ?>"/>
                </p>
                <p>
                    <label
                        for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Tweets:', $this->plugin_name); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>"
                           name="<?php echo $this->get_field_name('number'); ?>" type="number"
                           value="<?php echo esc_attr($number); ?>"/>
                </p>

                <p>
                    <label
                        for="<?php echo $this->get_field_id('include_retweets'); ?>"><?php _e('include_retweets ?', $this->plugin_name); ?></label>
                    <input class="widefat" type="checkbox" id="<?php echo $this->get_field_id('include_retweets'); ?>"
                           name="<?php echo $this->get_field_name('include_retweets'); ?>" <?php checked($include_retweets, 'on'); ?> >
                </p>

            </div>

            <!-- By Search -->
            <div class="utf_widget_by_search" <?php if ($type !== "by_search") {
                echo 'style="display: none;"';
            } ?>>
            <a style='margin:10px;' href="https://codecanyon.net/item/ultimate-twitter-feed-pro/19909481?ref=OmaR-K" name="submit" id="submit" class="button button-primary">Buy Pro Version</a>
            </div>

        </div>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        // Default
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['type'] = (!empty($new_instance['type'])) ? strip_tags($new_instance['type']) : '';


        // By User
        $instance['username'] = (!empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
        $instance['include_retweets'] = (!empty($new_instance['include_retweets'])) ? $new_instance['include_retweets'] : '';

        return $instance;
    }


}
