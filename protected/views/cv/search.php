<?php
/**
 * @var $searchString string
 * @var $offset int
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/comicvine.css");

function printPagination($result, $q) {
    if (isset($result['content']->offset) &&
        isset($result['content']->limit)
    ) {
        $totalResults = isset($result['content']->number_of_total_results) ? $result['content']->number_of_total_results : 0;
        echo("<div class = 'pagination_row'>\n");
        echo("<div class = 'left_pagination'>\n");
        if ($result['content']->offset != 0) {
            $lowerLimit = ($result['content']->offset - $result['content']->limit >= 0) ? $result['content']->offset - $result['content']->limit : 0;
            $upperLimit = $result['content']->offset - 1;
            $upperLimit = ($upperLimit > $totalResults - 1) ? $totalResults - 1 : $upperLimit;
            echo("<a href='" . Yii::app()->request->getBaseUrl() . '/' . Yii::app()->request->getPathInfo() . "?search=1&offset=$lowerLimit&q=$q'>Prev(" . ($lowerLimit + 1) . '-' . ($upperLimit + 1) . ")</a>\n");
        }
        echo("</div>");
        echo("<div class = 'center_pagination'>\n");
        $lowerLimit = $result['content']->offset;
        $upperLimit = $result['content']->offset + $result['content']->limit - 1;
        $upperLimit = ($upperLimit > $totalResults - 1) ? $totalResults - 1 : $upperLimit;
        echo('<center>');
        if ($totalResults == 0) {
            echo('Displaying entries 0-0 of 0.');
        } else {
            echo('Displaying entries ' . ($lowerLimit + 1) . '-' . ($upperLimit + 1) . " of $totalResults.");
        }
        echo('</center>');
        echo("</div>");
        $lowerLimit = $result['content']->offset +
            $result['content']->limit;
        if ($lowerLimit < $totalResults - 1) {
            $upperLimit = $result['content']->offset + 2 * $result['content']->limit - 1;
            $upperLimit = ($upperLimit > $totalResults - 1) ? $totalResults - 1 : $upperLimit;
            echo("<div class = 'right_pagination'>\n");
            echo("<a href='" . Yii::app()->request->getBaseUrl() . '/' . Yii::app()->request->getPathInfo() . "?search=1&offset=$lowerLimit&q=$q'>Next(" . ($lowerLimit + 1) . '-' . ($upperLimit + 1) . ")</a>\n");
            echo("</div>");
        }
        echo("</div>\n");
        echo("<div class='clear_left'></div>");
    }
}


$this->pageTitle = Yii::app()->name . ' - Comic Vine simple search results';
$this->breadcrumbs = array(
    'search ComicVine' => array('index'),
    'Search Results'
);
$this->menu = array(
    array('label' => 'CGridView sample', 'itemOptions' => array('title' => 'sample search for "spiderman"'), 'url' => array('search'), 'authItemName' => 'viewer'),
);
echo '<h1>Comic Vine API search results example</h1>';

if (isset($result)) {

    var_dump($searchString);

    if (isset($result['content'])) {
        if (isset($result['content']->results)) {
            echo "<div class = 'result_header'>Results</div>";
            foreach ($result['content']->results as $rec) {
                echo("<div class = 'result_row'>\n");
                echo("<div class = 'result_name'>\n");
                echo("<h2>$rec->name</h2>\n");
                echo("</div>\n");
                echo("<div class = 'result_details'>\n");
                echo("<a href='" . $rec->site_detail_url . "' target='_blank'>" . 'View Details' . "</a>\n");
                echo("</div>\n");
                echo("</div>\n");
                echo("<div class='clear_left'></div>");
            }
        }
        printPagination($result, $searchString);
    }
} else
    echo 'no result';

