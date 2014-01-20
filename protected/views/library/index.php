<h1>Library</h1>

<?php
/**
 * @var $this LibraryController
 * @var $dataProvider CActiveDataProvider
 */

if (Yii::app()->user->hasFlash('success')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('success') . '</div>';
}
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'book-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'title',
        'issue_number',
        array(
            'name' => 'type',
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
            'name' => 'status',
            'header' => 'Status',
            'value' => array($dataProvider->model, 'get_status'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{request}',
            'buttons' => array(
                'request' => array(
                    'label' => 'Request',
                    'imageUrl' => Yii::app()->baseUrl . '/images/request_lozenge.png',
                    'url' => 'Yii::app()->createUrl("library/request", array("id"=>$data->id))',
                    'visible' => array($dataProvider->model, 'requested'),
                ),
            ),
        ),
    ),
));

?>
