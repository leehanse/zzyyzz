<?php
    require_once('includes/TwitterFeed.php'); 
    $twitterFeed = new TwitterFeed('magento', 5);
    $tweets      = $twitterFeed->getTweets();
?>

<html>
    <head>
        <title>Get Twitter</title>
        <style type="text/css">
            #tweets {
                width: 600px;
                font: 85% Arial, sans-serif;
                margin: 2em auto;
            }

            #tweets-wrapper {
                padding-left: 60px;
                background: url(https://twitter.com/images/resources/twitter-bird-blue-on-white.png) no-repeat 0 50%;
                background-size: 60px 60px;
            }

            #tweets-wrapper div.tweet {
                margin-bottom: 1em;
                border-radius: 4px;
                color: #333;
                padding: 8px;
                border: 1px solid #ddd;
                line-height: 1.3;
            }

            #tweets-wrapper div.tweet a {
                color: #08c;
            }

            #tweets-wrapper div.tweet-actions {
                margin: 1em 0;
                padding-top: 0.3em;
                border-top: 1px solid #ddd;
            }

            #tweets-wrapper div.tweet-actions a {
                font-size: 95%;
                margin-right: 0.5em;
            }
        </style>        
    </head>
    <body>
        <?php if(count($tweets)): ?>  
                <div id="tweets-wrapper">
            <?php foreach($tweets as $item): ?>
                <?php 
                    $tweet = $item->text;
                    $time  = $item->created_at;
                    $id    = $item->id_str;
                ?> 
                    <div class="tweet">
                        <?php echo $tweet;?>
                        <small><?php echo date('Y-m-d H:i:s',  strtotime($time));?></small>
                        <div class="tweet-actions">
                            <a class="tweet-reply" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $id;?>" target="_blank">Reply</a>
                            <a class="tweet-retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo $id;?>" target="_blank">Retweet</a>
                            <a class="tweet-favorite" href="https://twitter.com/intent/favorite?tweet_id=<?php echo $id;?>" target="_blank">Favorite</a>
                        </div>
                    </div>    
                    <br/>
            <?php endforeach;?>
                </div>
        <?php endif;?>           
    </body>
</html>