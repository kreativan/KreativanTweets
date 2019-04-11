<?php
/**
 *  KreativanTweets Module
 *
 *  @author Ivan Milincic <kreativan@outlook.com>
 *  @copyright 2018 Ivan Milincic
 *
 *
*/

class KreativanTweets extends WireData implements Module {

    public static function getModuleInfo() {
		return array(
				'title' => 'Twitter Feed',
				'summary' => 'Twitter feed based on TweetPHP',
				'version' => '1.0',
				'author' => 'Ivan Milincic',
				'href' => 'http://kreativan.net/',
                'singular' => true,
    			'autoload' => false,
			);
	}

    public function init() {

    }

    /**
	 * Define the cache path
	 *
	 * Should be done here in the construct rather than the init() because init() is not called on install/uninstall
	 *
	 */
	public function __construct() {
		$this->cachePath = $this->config->paths->cache . $this->className() . '/';
	}

    /**
     * Install the module
     */
    public function ___install() {
        if(!$this->createCachePath()) throw new WireException("Unable to create directory: {$this->cachePath}");
    }

    /**
     * Uninstall the module
     */
    public function ___uninstall() {
        if(is_dir($this->cachePath)) wireRmdir($this->cachePath, true);
    }

    protected function createCachePath() {
		$path = $this->cachePath;
		if(!is_dir($path)) if(!wireMkdir($path)) return false;
		return true;
	}


    /**
     *  Render Tweeter Feed
     *	
	 *	@param array $params - Main params array
     *  @param string profile
     *  @param integer limit
     *  @param bool debug
     *  @param bool show_thumb 
     *  @param bool twitter_icon
     *
     *  @param markup
     *
     */
    public function render($params = array()) {

        $profile            = !empty($params['profile']) ? $params['profile'] : "";
        $limit              = !empty($params['limit']) ? $params['limit'] : "3";
        $cache              = !empty($params['cache']) ? $params['cache'] : true;
        $debug              = !empty($params['debug']) ? $params['debug'] : false;
        $show_thumb         = !empty($params['show_thumb']) ? $params['show_thumb'] : true;
        $twitter_icon       = !empty($params['twitter_icon']) ? $params['twitter_icon'] : true;
        $markup_file        = !empty($params['markup']) ? $params['markup'] : "default";

        require_once("./TweetPHP/TweetPHP.php");

        $TweetPHP = new TweetPHP(array(
            'consumer_key'        => $this->twitter_consumer_key,
            'consumer_secret'     => $this->twitter_consumer_secret,
            'access_token'        => $this->twitter_access_token,
            'access_token_secret' => $this->twitter_access_token_secret,
            'api_endpoint'        => 'statuses/user_timeline',
            'enable_cache'        => $cache,
            'cache_dir'           => $this->cachePath, // Where on the server to save cached tweets
            'cachetime'           => 60 * 60, // Seconds to cache feed (1 hour).
            'tweets_to_retrieve'  => "25", // Specifies the number of tweets to try and fetch, up to a maximum of 200
            'tweets_to_display'   => $limit, // Number of tweets to display
            'debug'               => $debug,
            'api_params'          => array('screen_name' => $profile),
        ));

        $tweet_array = $TweetPHP->get_tweet_array();

        $vars = [
            "TweetPHP" => $TweetPHP,
            "tweet_array" =>$tweet_array,
            "show_thumb" => $show_thumb,
            "twitter_icon" => $twitter_icon,
            "limit" => $limit,
        ];

        $file = $this->config->paths->siteModules . $this->className() . "/markup/$markup_file.php";
		return $this->files->render($file, $vars);

    }

    // relative time function
    public function time_ago($datetime, $full = false) {

        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';

    }

}
