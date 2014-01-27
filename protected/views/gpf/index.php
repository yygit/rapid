<?php
/**
 * @var $activityList array
 * @var $authUrl string
 */

$this->breadcrumbs = array(
    'gpf',
);
?>
<h1>Google+ Comic Book News Feed</h1>
<div class="box">
    <?php if (count($activityList)): ?>
        <div class="activities"><h2>Your personal comic book news feed: </h2>
            <?php
            foreach ($activityList as $activityListItem) {
                echo("<div class='activity'><a href='" .
                    $activityListItem['url'] . "'>" .
                    $activityListItem['title'] . '</a><div>' .
                    $activityListItem['content'] . "</div>\n");
                foreach ($activityListItem['images'] as $imageUrl) {
                    echo('<img src="' . $imageUrl . '">');
                    echo("</div><div><center><img src='" . Yii::app()->request->baseUrl . "/images/hdiv.png' /></center></div>\n");
                }
            }
            ?>
        </div>
    <?php endif;
    if ($authUrl) {
        print "<a class='login' href='$authUrl'>Connect Me!</a>";
    } else {
        print "<a class='logout' href='?logout'>Logout</a>";
    }
    ?>
</div>
