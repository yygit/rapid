<h1>Library</h1>

<?php
/**
 * @var $this LibraryController
 * @var $dataProvider CActiveDataProvider
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'book-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'title',
        'issue_number',
        array(
            'name' => 'Type',
            'value' => '$data->type->name',
        ),
        /*array(
            'name' => 'Publisher',
            'header' => 'Publisher',
            'value' => '(($data->publisher!=null) ? $data->publisher->name : "")',
        ),*/
        array(
            'name' => 'publishers',
            'value' => array($dataProvider->model, 'publisher_list'),
        ),
        array(
            'name' => 'authors',
            'value' => array($dataProvider->model, 'author_list'),
        ),
        'publication_date',
        array(
            'class' => 'CButtonColumn',
            'template' => '{request}',
            'buttons' => array(
                'request' => array(
                    'label' => 'Request',
                    'imageUrl' => Yii::app()->baseUrl . '/images/request_lozenge.png',
                    'url' => 'Yii::app()->createUrl("library/request", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));

?>
