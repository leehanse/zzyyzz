<?php
require_once('twitteroauth.php');

class TwitterFeed {
	public $user;
	public $tweetsNumber;
	private $consumerKey = 'Y0fK3iEu2tLq4iz9sHWvw';
	private $consumerSecret = '0r4drPZTh4CrrDXZwdLvshwxHFhYoewtWSaC7CQ';
	private $accessToken = '127613117-T5t2o7SIXg2TbrNHaG7QR25MqPHKpwDHZx19up3L';
	private $accessTokenSecret = 'LteVyxSty41ZBztjvhGbCMLDuYy2UVqd1GjyQSOVv6Q';
	private $connection;
	
	public function __construct($username, $tweets) {
            $this->user = $username;
            $this->tweetsNumber = $tweets;
            $this->connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
	}
	
	public function getTweets() {
            $tweets = $this->connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $this->user . '&count=' . $this->tweetsNumber);
            return $tweets;
	}
        
        public function getUserProfile($screen_name = 'magento'){
            $user_profile = $this->connection->get('https://api.twitter.com/1.1/users/show.json?screen_name='.$screen_name);
            return $user_profile;            
        }
        
	
}