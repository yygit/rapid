<?php
/**
 * @var $this CvController
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/comicvine.css");
$this->pageTitle = Yii::app()->name . ' - Comic Vine issues sample';
$this->breadcrumbs = array(
    'search ComicVine' => array('index'),
    'Issues',
);
$this->menu = array(
    array('label' => 'CGridView sample', 'itemOptions' => array('title' => 'sample search for "spiderman"'), 'url' => array('search'), 'authItemName' => 'viewer'),
);
if (isset($error)) {
    echo($error);
} else {
    ?>
    <h1>Comic Vine issues sample</h1>
    <div class='search_header'>
        <?php
        var_dump(@reset($result)->volume->id); // volume ID
        if (isset($title)) {
            echo("<center><u><h3>$title</h3><u></center>");
        }
        ?>
    </div>
    <?php
    foreach ($result as $issue) {
        echo("<div class='search_row'>\n");
        echo("<div class='issue_number'>\n");
        echo((int)$issue->issue_number);
        echo("</div>");
        echo("<div class='issue_name'>\n");
        echo($issue->name ? CHtml::encode($issue->name) : '&nbsp;');
        echo("</div>");
        echo("<div class='issue_detail'>\n");
        echo CHtml::link('Details', array('', 'volume_id' => $issue->volume->id, 'issue_url' => $issue->site_detail_url), array('target' => '_blank'));
        echo("</div>");
        echo("<div style='clear: left;'></div>");
        echo("</div>\n");
    }
}
?>

