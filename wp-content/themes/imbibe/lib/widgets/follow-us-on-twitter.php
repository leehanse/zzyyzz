<?php
require_once (get_template_directory().'/lib/twitter-feed/includes/TwitterFeed.php');

function time_delta($start='now', $target='', $precision=0, $labels=2, $suffix=true)
{
        date_default_timezone_set('America/Los_Angeles'); // PHP complains if this isn't set, for some reason
        // Define all time units in terms of seconds
        $units = array(
                        'y'  => array('year', 31556926), // Source: Google calculator
                        'mo' => array('month', 2629744), // Source: Google calculator
                        'w'  => array('week', 604800),
                        'd'  => array('day', 86400),
                        'h'  => array('hour', 3600),
                        'm'  => array('minute', 60),
                        's'  => array('second', 1)
                        );

        // Some basic sanity checking
        if (empty($target)) return "No target time specified.\n";
        if ($start < 0) return "Invalid start time.\n";
        if (!array_key_exists($precision, $units) AND $precision > 2) return "Improper value for precision.\n";
        if (!is_int($labels) OR !is_bool($suffix)) return "Improper values for labels and/or suffix.\n";
        if (!is_int($target) AND !strtotime($target)) return "Could not understand your target time.\n";
        if (!is_int($start) AND !strtotime($start)) return "Could not understand your start time.\n";

        // Set some sensible defaults
        $fuzz_factor = 0.8; // How close to the next value will we call it "about" something?
        if ($precision < 0 OR $precision > 2) $precision = 2;
        if ($labels < 0 OR $labels > 2) $labels = 2;
        if (!is_int($start)) $start = strtotime($start);
        if (!is_int($target)) $target = strtotime($target);

        // Are we past or future?
        $ending = ($target > $start) ? " from now" : " ago";

        // Calculate time difference & initialize output string
        $delta = abs($target - $start);
        $out = '';

        // Calculate for single-unit precision
        if (is_string($precision))
        {
                if ($delta < $units[$precision][1])
                {
                        $out .= "Less than one {$units[$precision][0]}";
                        return ($suffix === true) ? $out.$ending : $out;
                }
                else
                {
                        $out .= intval(($delta / $units[$precision][1]));
                        if ($labels == 0) return $out;
                        $out .= ($labels == 1) ? $precision : ' '.$units[$precision][0]
                             .  (($out > 1 AND $labels >= 2) ? 's' : '');
                        return ($suffix === true) ? $out.$ending : $out;
                }
        }

        /* Calculate fuzzy precision
           -------------------------
          Fuzzy precision should output only one unit of precision
          and use the modifier "about" if the remainder is > $fuzz_factor.
        */
        if ($precision == 0)
        {
                foreach ($units as $unit => $type)
                {
                        if ($delta >= $type[1] * $fuzz_factor)
                        {
                                $fuzzy = (fmod(($delta / $type[1]), 1) > $fuzz_factor) ? true : false;
                                if ($labels > 0 AND $labels >= 2) $out .= ($fuzzy === true) ? 'About ' : '';
                                $diff = ($fuzzy === true) ? ceil($delta / $type[1]) : intval($delta / $type[1]);
                                if ($diff == 1 AND $fuzzy === true) $out .= ($unit == 'h') ? 'an ' : 'a ';
                                else $out .= $diff;
                                if ($labels == 0) return $diff;
                                $out .= ($labels > 1 OR $fuzzy === false) ? ' ' : ''; 
                                $out .= ($labels == 1) ? $unit : $type[0];
                                $out .= ($diff > 1 AND $labels > 1) ? 's' : '';
                                return ($suffix === true) ? $out.$ending : $out;
                        }
                }
        }
                
        /* Calculate approximate and exact precision
           -----------------------------------------
          Approximate precision outputs up to 2 units of measure, exact prints
          as many as we have.
        */
        else
        {
                $max = ($precision == 1) ? 2 : count($units); // Iterate twice if approximate precision
                $i = 0;
                foreach ($units as $unit => $type)
                {
                        if ($delta >= $type[1] AND $i < $max)
                        {
                                $diff = intval($delta / $type[1]);
                                $out .= $diff.(($labels > 1) ? (' '.$type[0]) : (($labels == 0) ? ' ' : $unit)).(($diff > 1 AND $labels > 1) ? ('s') : (''));
                                $delta -= intval($delta / $type[1]) * $type[1];
                                $out .= ($i == 0 AND $precision == 1 AND $labels > 0 AND !empty($diff)) ? ' and ' : '';
                                $next_index = array_search($unit,array_keys($units)) + 1;
                                $units_numeric = array_values($units);
                                if (array_key_exists($next_index, $units_numeric)) $next = $units_numeric[$next_index][1];
                                $and = ($precision == 2 AND $labels > 0 AND ($delta % $next == 0) AND $unit != 's');
                                $out .= $and ? ' and ' : (($labels > 0 AND $unit != 's' AND $precision != 1) ? ', ' : '' );
                                $i++;
                        }
                }
                return ($suffix === true) ? $out.$ending : $out;
        }
}

add_action( 'widgets_init', 'widget_init_follow_us_on_twitter' );


function widget_init_follow_us_on_twitter() {
	register_widget( 'FollowUsOnTwitter_Widget' );
}

class FollowUsOnTwitter_Widget extends WP_Widget {

	function FollowUsOnTwitter_Widget() {
		$widget_ops = array( 'classname' => 'follow-us-on-twitter', 'description' => __('Follow Us On Twitter', 'follow-us-on-twitter') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'follow-us-on-twitter-widget' );
		
		$this->WP_Widget( 'follow-us-on-twitter-widget', __('Follow Us On Twitter', 'follow-us-on-twitter'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
            $twitterFeed = new TwitterFeed(get_theme_option('imbibe_twitter_id'), 3);
            $tweets      = $twitterFeed->getTweets();                        
        ?>
            <section class="followTwitter">
            	<div class="headingTitle"><h1>Follow Us on Twitter</h1></div>
                <?php if(count($tweets)): ?>  
                    <?php foreach($tweets as $item): ?>
                        <?php
                            $tweet = $item->text;
                            $time  = $item->created_at;
                            $id    = $item->id_str;
                            if($item->retweeted_status){
                                $profile_image_url  = $item->retweeted_status->user->profile_image_url;
                                $profile_url        = 'https://twitter.com/account/redirect_by_id?id='.$item->retweeted_status->user->id;
                            }else{ 
                                $profile_image_url  = $item->user->profile_image_url;
                                $profile_url        = 'http://twitter.com/'.$item->user->name;
                                $profile_url        = 'https://twitter.com/account/redirect_by_id?id='.$item->user->id;
                            }
                        ?>                 
                <div class="blockFollow">
                    <div class="avt">
                        <a href="<?php echo $profile_url;?>">
                            <img src="<?php echo $profile_image_url;?>"/>
                        </a>
                    </div>
                    <div class="des">
                        <p><?php echo $tweet;?></p>
                        <ul class="link">
                            <li class="time"><?php echo time_delta('now', $time);?></li>
                            <li><a class="tweet-reply" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $id;?>" target="_blank">Reply</a></li>
                            <li><a class="tweet-retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo $id;?>" target="_blank">Retweet</a></li>
                            <li><a class="tweet-favorite" href="https://twitter.com/intent/favorite?tweet_id=<?php echo $id;?>" target="_blank">Favorite</a></li>
                        </ul>
                    </div>
                </div>                
                <?php endforeach;?>
                <div class="btnJoin"><a href="https://twitter.com/<?php echo get_theme_option('imbibe_twitter_id')?>">Join the Conversation »</a></div>
                <?php endif;?>
            </section>            
        <?php        
	}
        
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            return $instance;
	}

	
	function form( $instance ) {
            $defaults = array( 'title' => '');
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
            <!--
            <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
                    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
            </p>
            -->
	<?php
	}
}
?>