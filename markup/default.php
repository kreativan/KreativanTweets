<?php
/**
 *  Twitter Feed
 *
 *  @author Ivan Milincic <kreativan@outlook.com>
 *  @copyright 2018 Kreativan
 *
 *  @var tweet_array
 *
*/

$this->module = $this->modules->get("KreativanTweets");
$this_module_folder = $this->config->paths->siteModules . $this->module->className();

$i = 1;

?>

<ul class="twitter-feed" style="list-style:none;padding:0;margin:0;">
    <?php foreach($tweet_array as $tweet) :?>

        <?php

            if($i++ > $limit) break;

            $screen_name = $tweet['user']['screen_name'];
            $tweet_link  = !empty($tweet['entities']['urls']) ? $tweet['entities']['urls']['0']['url'] : "";
            $thumb = $tweet['user']['profile_image_url'];
        ?>

        <li style="clear: both;margin-bottom:10px;">

            <?php if($show_thumb == true) :?>
                <div style="float:left;margin-right: 15px;margin-top:7px;">
                    <img src="<?= $thumb ?>" width="58" height="58" />
                </div>
            <?php endif;?>

            <div>
                <?php if($twitter_icon == true) :?>
                    <span style="position:relative;">
                        <?php echo file_get_contents($this_module_folder . "/markup/twitter.svg"); ?>
                    </span>
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
