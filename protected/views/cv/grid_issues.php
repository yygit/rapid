<?php
/**
 * @var $dataProvider CArrayDataProvider
 * @var $volumeId int
 * @var $volumeName string
 */
$this->pageTitle = Yii::app()->name . ' - Comic Vine issues GridView';
$this->breadcrumbs = array(
    'search ComicVine' => array('index'),
    'issues GridView'
);
$this->menu = array(
    array('label' => 'CVine index', 'url' => array('index'), 'authItemName' => 'viewer'),
);
echo '<h1>Issues for volume #' . $volumeId . ' - ' . $volumeName . '</h1>';

//var_dump($volumeId);
//var_dump($dataProvider->data);
//Yii::app()->end();

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'issues-grid',
    'ajaxUpdate' => false,
    'dataProvider' => $dataProvider,
    'hideHeader' => false,
//    'template' => "{summary}\n{items}\n{pager}",
    'columns' => array(
        'issue_number:html:Issue Number',
        'name:html:Name',
        array(
            'class' => 'CLinkColumn',
            'label' => 'Go',
            'urlExpression' => '$data->site_detail_url',
            'linkHtmlOptions' => array('target' => '_blank'),
        ),
    ),
));
