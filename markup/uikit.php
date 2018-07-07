<?php
/**
 *  UIkit Twitter Feed
 *
 *  @author Ivan Milincic <kreativan@outlook.com>
 *  @copyright 2018 Kreativan
 *
 *  @var tweet_array
 *
*/

$this->module = $this->modules->get("KreativanTweets");

$i = 1;

?>

<ul class="tm-twitter-feed uk-list uk-margin-remove-top">
    <?php foreach($tweet_array as $tweet) :?>

        <?php
            if($i++ > $limit) break;

            $screen_name = $tweet['user']['screen_name'];
            $tweet_link  = !empty($tweet['entities']['urls']) ? $tweet['entities']['urls']['0']['url'] : "";
            $thumb = $tweet['user']['profile_image_url'];
        ?>

        <li>
            <?php if($show_thumb == true) :?>
                <div class="uk-align-left uk-visible@m" style="margin-right:10px;margin-bottom:10px;margin-top:5px;">
                    <img class="uk-border-rounded" data-src="<?= $thumb ?>" uk-img width="58" height="58" uk-img />
                </div>
            <?php endif;?>
            <div>
                <?php if($twitter_icon == true) :?>
                    <i class='fab fa-twitter' style='color:#1BA1F3'></i>
                <?php endif;?>
                <a href="https://twitter.com/<?= $screen_name ?>" target="_blank" rel="nofollow">
                    @<?= $screen_name ?>
                </a>
                <span class="uk-text-small">
                    <?= $this->module->time_ago($tweet['created_at']); ?>
                </span>
            </div>
            <div>
                <?php echo $TweetPHP->autolink($tweet['text']);?>
            </div>
        </li>
    <?php endforeach;?>
</ul>
