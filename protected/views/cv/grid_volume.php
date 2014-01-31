<?php
/**
 * @var $this CvController
 * @var $dataProvider CArrayDataProvider
 * @var $result array
 * @var $id_arr array
 * @var $page int
 * @var $searchString string
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/grid-custom.css");
$this->pageTitle = Yii::app()->name . ' - Comic Vine GridView search results';
$this->breadcrumbs = array(
    'search ComicVine' => array('index'),
    'Search Results'
);
$this->menu = array(
    array('label' => 'CVine index', 'url' => array('index'), 'authItemName' => 'viewer'),
);
echo '<h1>Volume search results</h1>';

/*
 * Pagination object (CPagination) should always refer to the 1st page of the retrieved $result array.
 * 'summaryText' of the Cgridview and 'currentPage' of the Pager are custom made and refer to real pages
 * of the data NOT YET retrieved from 'Comic Vine'.
 */
$_GET['page'] = 1;

var_dump($searchString);
//var_dump($result);
//Yii::app()->end();

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'test-grid',
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'hideHeader' => false,
    'summaryText' => 'results ' . @min($id_arr) . ' - ' . @max($id_arr) . ' of total {count}',
//    'template' => "{summary}\n{items}\n{pager}",
    'pager' => array(
        'class' => 'CListPager',
        'currentPage' => $page - 1,
//         'footer' => 'this is a footer',
//         'header' => 'this is a header',
    ),
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'url',
            'value' => '$data["url"]',
        ),
        array(
            'class' => 'CLinkColumn',
            'labelExpression' => '"Vol. #" . $data["volume_id"]',
            'urlExpression' => '$data["url"]',
            'linkHtmlOptions' => array('target' => '_blank'),
            'cssClassExpression' => '"volume-link"',
        ),
        array(
            'class' => 'CLinkColumn',
            'label' => 'Issues',
            'urlExpression' => 'Yii::app()->createUrl("cv/issues", array("volume_id" => $data["volume_id"], "grid" => 1))',
            'linkHtmlOptions' => array('target' => '_blank'),
        ),
    ),
));
