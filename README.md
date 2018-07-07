# KreativanTweets
Processwire Twitter Feed Module base on [TweetPHP](https://github.com/jnicol/tweet-php) class.

* Works with Twitter API v1.1
* Tweets are cached to avoid exceeding Twitter’s API request rate limits
* Supports multiple tweet templates/layouts/html markup
* Using relative time/date (eg: 1 week ago)

There is currently two twitter feed layouts: default and uikit, you can add your own layout in markup folder. You can copy default.php, rename it and edit markup to fit your needs.

### Usage
```
$tweets = $modules->get("KreativanTweets");
echo $tweets->render();
```
#### using options
```
$options = [
    "profile" => "my_profile", // profile to display tweets from
    "limit" => "4", // numer of tweets to display
    "debug" =>  false, // debug mode, enable if u have problems fetching the tweets
    "cache" => true, // caching tweets
    "show_thumb" => true, // display user thumbnail
    "twitter_icon" => true, // display twitter icon
    "markup" => "default", // feed layout file to load, from /markup/ folder
];
$tweets = $modules->get("KreativanTweets");
echo $tweets->render($options);
```
