<?php
/**
 * Themes Kingdom Widgets
 *
 * 1. Twitter widget
 * 2. Newsletter widget
 * 3. Facebook widget
 *
 * @package Eveny
 */

/**
 * -----------------------------------
 * 1. Twitter widget
 * -----------------------------------
 */
class App_Twitter extends WP_Widget {

    public function __construct() {
        parent::__construct(false, $name = __(wp_get_theme()->name . ' - Twitter', 'eveny'));
    }


    //widget output
    public function widget($args, $instance) {
        extract($args);
        if(!empty($instance['title'])){ $title = apply_filters( 'widget_title', $instance['title'] ); }

        echo $before_widget;
        if ( ! empty( $title ) ){ echo $before_title . $title . $after_title; }

            //check settings and die if not set
            if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
                echo '<strong>'.__('Please fill all widget settings!','eveny').'</strong>' . $after_widget;
                return;
            }


            //check if cache needs update
            $eveny_twitter_last_cache_time = get_option('eveny_twitter_last_cache_time');
            $diff = time() - $eveny_twitter_last_cache_time;
            $crt = $instance['cachetime'] * 3600;

            // yes, it needs update
            if($diff >= $crt || empty($eveny_twitter_last_cache_time)){

                if(!require_once( get_template_directory() . '/inc/apis/twitter/twitteroauth.php')){
                    echo '<strong>'. esc_html__('Couldn\'t find twitteroauth.php!','eveny') . '</strong>' . esc_attr( $after_widget );
                    return;
                }

                if ( ! function_exists( 'getConnectionWithAccessToken' ) ) :
                    function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
                      $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
                      return $connection;
                    }
                endif;

                $connection = getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
                $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=10&exclude_replies=".$instance['excludereplies']) or die('Couldn\'t retrieve tweets! Wrong username?');


                if(!empty($tweets->errors)){
                    if($tweets->errors[0]->message == 'Invalid or expired token'){
                        echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />' . __('You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!','eveny') . $after_widget;
                    }else{
                        echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
                    }
                    return;
                }

                $tweets_array = array();
                for($i = 0;$i <= count($tweets); $i++){
                    if(!empty($tweets[$i])){
                        $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;

                            //clean tweet text
                            $tweets_array[$i]['text'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $tweets[$i]->text);

                        if(!empty($tweets[$i]->id_str)){
                            $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
                        }
                    }
                }

                //save tweets to wp option
                    update_option('tp_twitter_plugin_tweets',serialize($tweets_array));
                    update_option('eveny_twitter_last_cache_time',time());

                echo '<!-- twitter cache has been updated! -->';
            }

            $tp_twitter_plugin_tweets = maybe_unserialize(get_option('tp_twitter_plugin_tweets'));
            if(!empty($tp_twitter_plugin_tweets) && is_array($tp_twitter_plugin_tweets)){
                print '
                <div class="tp_recent_tweets">
                    <ul>';
                    $fctr = '1';
                    foreach($tp_twitter_plugin_tweets as $tweet){
                        if(!empty($tweet['text'])){
                            if(empty($tweet['status_id'])){ $tweet['status_id'] = ''; }
                            if(empty($tweet['created_at'])){ $tweet['created_at'] = ''; }

                            print '<li><span>'.tp_convert_links($tweet['text']).'</span><br /><a class="twitter_time" target="_blank" href="http://twitter.com/'.$instance['username'].'/statuses/'.$tweet['status_id'].'">'.tp_relative_time($tweet['created_at']).'</a></li>';
                            if($fctr == $instance['tweetstoshow']){ break; }
                            $fctr++;
                        }
                    }

                print '
                    </ul>
                </div>';
            }else{
                print '
                <div class="tp_recent_tweets">
                    ' . __('<b>Error!</b> Couldn\'t retrieve tweets for some reason!','eveny') . '
                </div>';
            }

            echo $after_widget;
        }


    //save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
        $instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
        $instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
        $instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
        $instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
        $instance['username'] = strip_tags( $new_instance['username'] );
        $instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
        $instance['excludereplies'] = strip_tags( $new_instance['excludereplies'] );

        if($old_instance['username'] != $new_instance['username']){
            delete_option('eveny_twitter_last_cache_time');
        }

        return $instance;
    }


    //widget settings form
        public function form($instance) {
            $defaults = array( 'title' => '', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '', 'username' => '', 'tweetstoshow' => '' );
            $instance = wp_parse_args( (array) $instance, $defaults );

            echo '
            <p><label>' . __('Title:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'title' ).'" id="'.$this->get_field_id( 'title' ).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p>
            <p><label>' . __('Consumer Key:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'consumerkey' ).'" id="'.$this->get_field_id( 'consumerkey' ).'" value="'.esc_attr($instance['consumerkey']).'" class="widefat" /></p>
            <p><label>' . __('Consumer Secret:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'consumersecret' ).'" id="'.$this->get_field_id( 'consumersecret' ).'" value="'.esc_attr($instance['consumersecret']).'" class="widefat" /></p>
            <p><label>' . __('Access Token:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'accesstoken' ).'" id="'.$this->get_field_id( 'accesstoken' ).'" value="'.esc_attr($instance['accesstoken']).'" class="widefat" /></p>
            <p><label>' . __('Access Token Secret:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'accesstokensecret' ).'" id="'.$this->get_field_id( 'accesstokensecret' ).'" value="'.esc_attr($instance['accesstokensecret']).'" class="widefat" /></p>
            <p><label>' . __('Cache Tweets in every:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'cachetime' ).'" id="'.$this->get_field_id( 'cachetime' ).'" value="'.esc_attr($instance['cachetime']).'" class="small-text" /> hours</p>
            <p><label>' . __('Twitter Username:','eveny') . '</label>
                <input type="text" name="'.$this->get_field_name( 'username' ).'" id="'.$this->get_field_id( 'username' ).'" value="'.esc_attr($instance['username']).'" class="widefat" /></p>
            <p><label>' . __('Tweets to display:','eveny') . '</label>
                <select type="text" name="'.$this->get_field_name( 'tweetstoshow' ).'" id="'.$this->get_field_id( 'tweetstoshow' ).'">';
                $i = 1;
                for(i; $i <= 10; $i++){
                    echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>';
                }
                echo '
                </select></p>
            <p><label>' . __('Exclude replies:','eveny') . '</label>
                <input type="checkbox" name="'.$this->get_field_name( 'excludereplies' ).'" id="'.$this->get_field_id( 'excludereplies' ).'" value="true"';
                if(!empty($instance['excludereplies']) && esc_attr($instance['excludereplies']) == 'true'){
                    print ' checked="checked"';
                }
                print ' /></p>';
        }
}


//convert links to clickable format
if (!function_exists('tp_convert_links')) {
    function tp_convert_links($status,$targetBlank=true,$linkMaxLen=250){

        // the target
            $target=$targetBlank ? " target=\"_blank\" " : "";

        // convert link to url
            $status = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a href="\0" target="_blank">\0</a>', $status);

        // convert @ to follow
            $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

        // convert # to search
            $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

        // return the status
            return $status;
    }
}


//convert dates to readable format
if (!function_exists('tp_relative_time')) {
    function tp_relative_time($a) {
        //get current timestampt
        $b = strtotime('now');
        //get timestamp when tweet created
        $c = strtotime($a);
        //get difference
        $d = $b - $c;
        //calculate different time values
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;

        if(is_numeric($d) && $d > 0) {
            //if less then 3 seconds
            if($d < 3) return __('right now','eveny');
            //if less then minute
            if($d < $minute) return floor($d) . __(' seconds ago','eveny');
            //if less then 2 minutes
            if($d < $minute * 2) return __('about 1 minute ago','eveny');
            //if less then hour
            if($d < $hour) return floor($d / $minute) . __(' minutes ago','eveny');
            //if less then 2 hours
            if($d < $hour * 2) return __('about 1 hour ago','eveny');
            //if less then day
            if($d < $day) return floor($d / $hour) . __(' hours ago','eveny');
            //if more then day, but less then 2 days
            if($d > $day && $d < $day * 2) return __('yesterday','eveny');
            //if less then year
            if($d < $day * 365) return floor($d / $day) . __(' days ago','eveny');
            //else return more than a year
            return __('over a year ago','eveny');
        }
    }
}
register_widget('App_Twitter');


/**
 * -----------------------------------
 * 2. Newsletter widget
 * -----------------------------------
 */
class App_Newsletter extends WP_Widget {

    function App_Newsletter() {
        $widget_ops = array('description' => 'Newsletter Widget support 2 newsletter services MadMimi and MailChimp');
        parent::__construct(false, $name = __(wp_get_theme()->name . ' - Newsletter', 'eveny'), $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title              = $instance['title'];
        $newsletter_service = $instance['service'];
        $mailchimp_key      = $instance['mailchimp_key'];
        $mailchimp_list     = $instance['mailchimp_list'];
        $newsletter_text    = $instance['newsletter_text'];
        $madmimi_signup     = $instance['madmimi_user'];
        ?>

        <?php echo $before_widget; ?>
        <?php if ($title) {
            echo $before_title . $title . $after_title;
        } ?>

        <?php if (!empty($newsletter_service)) { ?>
            <div class="newsleter-widget">
                <?php if (!empty($newsletter_text)) { ?><p><?php echo esc_html( $newsletter_text ); ?></p><?php } ?>
                <div id="newsleter-form-footer">

                <?php if ($newsletter_service == 'MadMimi') { ?>
                    <form action="https://madmimi.com/signups/subscribe/<?php echo esc_attr($madmimi_signup); ?>" method="post" id="mad_mimi_signup_form" target="_blank" onsubmit="return MadMimiNewsletter()">
                        <div id="s" class="newsletter">
                            <input id="signup_email" name="signup[email]" type="text" placeholder="" data-invalid-message="This field is invalid" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" class="required newsletter_email input-newsletter" value="<?php _e('ENTER YOUR EMAIL...','eveny'); ?>">
                            <input id="webform_submit_button" value="<?php _e('SUBSCRIBE','eveny'); ?>" type="submit" class="submit newsletter_button btn submit-newsletter" data-default-text="" data-submitting-text="" data-invalid-text="">
                            <div class="mimi_field_feedback eveny_newsletter_response"></div><span class="mimi_funk"></span>
                        </div>
                    </form>
                <?php } elseif ($newsletter_service == 'MailChimp') { ?>
                    <form id="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <div id="s" class="newsletter">
                                <input type="text" name="email" id="email"  class="input-newsletter" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php _e('ENTER YOUR EMAIL...','eveny'); ?>"/>
                                <input type="hidden" name="_mailchimp_key" id="_mailchimp_key" value="<?php echo esc_attr($mailchimp_key); ?>"/>
                                <input type="hidden" name="_mailchimp_list" id="_mailchimp_list" value="<?php echo esc_attr($mailchimp_list); ?>"/>
                                <input type="submit" src="" name="submit" value="<?php esc_attr_e('SUBSCRIBE','eveny'); ?>" class="btn submit-newsletter" alt="Submit" />
                            <input type="text" style="display: none" value="<?php echo esc_url( get_template_directory_uri() ) . '/inc/apis/mailchimp/inc/store-address.php'; ?>" name="hidden_path" class="hidden_path">
                            <div class="clear"></div>
                            <label for="email" id="address-label">
                                    <span id="response">
                                        <?php get_template_part('/inc/apis/mailchimp/inc/store-address.php');
                                        if (isset($_GET['submit'])) {
                                            echo storeAddress();
                                        } ?>
                                    </span>
                            </label>
                        </div>
                    </form>
                    <script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/apis/mailchimp/js/mailing-list.js'; ?>"></script>
                <?php } ?>

                </div>
            </div>

            <?php echo $after_widget; ?>
        <?php
        }
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {

        if (isset($instance['title'])) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (isset($instance['service'])) {
            $newsletter_service = esc_attr($instance['service']);
        } else {
            $newsletter_service = '';
        }

        if (isset($instance['mailchimp_key'])) {
            $mailchimp_key = esc_attr($instance['mailchimp_key']);
        } else {
            $mailchimp_key = '';
        }

        if (isset($instance['mailchimp_list'])) {
            $mailchimp_list = esc_attr($instance['mailchimp_list']);
        } else {
            $mailchimp_list = '';
        }

        if (isset($instance['madmimi_user'])) {
            $madmimi_username = esc_attr($instance['madmimi_user']);
        } else {
            $madmimi_username = '';
        }

        if (isset($instance['newsletter_text'])) {
            $newsletter_text = esc_attr($instance['newsletter_text']);
        } else {
            $newsletter_text = '';
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'eveny'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('newsletter_text')); ?>" class="nwsltr-txt-holder"><?php _e('Newsletter Text:', 'eveny'); ?></label>
            <textarea name="<?php echo esc_attr($this->get_field_name('newsletter_text')); ?>" id="<?php echo esc_attr($this->get_field_id('newsletter_text')); ?>" cols="31" rows="5"><?php echo $newsletter_text; ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('service')); ?>"><?php _e('Chose Service:', 'eveny'); ?></label><br/>
            <input type="radio" name="<?php echo esc_attr($this->get_field_name('service')); ?>" value="MadMimi" <?php if (empty($newsletter_service) || $newsletter_service == 'MadMimi') {
                echo 'checked';
            } ?>>  MadMimi<br/>
            <input type="radio" name="<?php echo esc_attr($this->get_field_name('service')); ?>" value="MailChimp" <?php if ($newsletter_service == 'MailChimp') {
                echo 'checked';
            } ?>>  MailChimp<br/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('madmimi_user')); ?>"><?php _e('MadMimi Unique Number:', 'eveny'); ?></label><br/>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('madmimi_user')); ?>"  value="<?php echo esc_attr($madmimi_username); ?>" class="" size="28" id="<?php echo esc_attr($this->get_field_id('madmimi_user')); ?>" /><br/>
            <span class="description"><?php _e('Insert your MadMimi unique number.Click ', 'eveny') ?><a href="https://madmimi.com/signups" target="_blank"><?php _e('here', 'eveny'); ?></a><?php _e(' or you can find this number when you log in into your MadMimi account, under WEBFORM click on SHARE and you will get link like this http://mad.ly/signups/<strong>XXXXX</strong>/join. Insert this number here.', 'eveny'); ?></span><br/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('mailchimp_key')); ?>"><?php _e('MailChimp API Key:', 'eveny'); ?></label><br/>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('mailchimp_key')); ?>"  value="<?php echo esc_attr($mailchimp_key); ?>" class="" size="28" id="<?php echo esc_attr($this->get_field_id('mailchimp_key')); ?>" /><br/>
            <span class="description">Grab and insert an API Key from <a href="http://admin.mailchimp.com/account/api/" target="_blank">here</a></span><br/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('mailchimp_list')); ?>"><?php _e('MailChimp API List:', 'eveny'); ?></label><br/>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('mailchimp_list')); ?>"  value="<?php echo esc_attr($mailchimp_list); ?>" class="" size="28" id="<?php echo esc_attr($this->get_field_id('mailchimp_list')); ?>" /><br/>
            <span class="description"><?php _e('Grab your Lists Unique Id by going to ', 'eveny'); ?><a href="http://admin.mailchimp.com/lists/" target="_blank"><?php _e('here', 'eveny'); ?></a>.<?php _e(' Click the "settings" link for the list - the Unique Id is at the bottom of that page.', 'eveny'); ?></span><br/>
        </p>

    <?php
    }

}
register_widget('App_Newsletter');

/**
 * -----------------------------------
 * 3. Facebook widget
 * -----------------------------------
 */
class App_Facebook extends WP_Widget {

    function App_Facebook() {
        $widget_ops = array('description' => 'Facebook, Add facebook box' );
        parent::__construct(false, __(wp_get_theme()->name.' - Facebook', 'tkingdom'),$widget_ops);
    }

    function widget($args, $instance) {
        extract( $args );
        $unique_id = $args['widget_id'];
        $url = $instance['url'];
        if(empty($url)) {
            $url = 'http://www.facebook.com/platform';
        }

        echo $before_widget; ?>

        <script>
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <div class="fb-page" data-href="<?php echo $url; ?>" data-width="100%" data-adapt-container-width="true"></div>
        <?php echo $after_widget; ?>
    <?php }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {

        if (isset($instance['url'])) {
            $url = esc_attr($instance['url']);
        } else {
            $url = '';
        }


        ?>
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Facebook link:', wp_get_theme()->name); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('url'); ?>"  value="<?php echo $url; ?>" class="widefat" id="<?php echo $this->get_field_id('url'); ?>" />
        </p>

    <?php
    }

}
register_widget('App_Facebook');
