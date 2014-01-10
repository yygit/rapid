<?php
/* @var $this WishController */
/* @var $model Wish */

$this->breadcrumbs = array(
    'Wishes' => array('wish/'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Wish', 'url' => array('index')),
    array('label' => 'Create Wish', 'url' => array('create')),
    array('label' => 'Update Wish', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Wish', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Wish', 'url' => array('admin')),
);
?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array_filter(array(
        'id',
        'title',
        'issue_number',
        'type_id',
        'type.name',
        'publication_date',
        array(
            'name' => 'store_link',
            'type' => "raw",
            'value' => empty($model->store_link) ? 'link not provided' : '<a href="' . $model->store_link . '" target="_blank">Purchase</a>',
        ),
        'notes',
        (Yii::app()->user->getName() != Yii::app()->params['God']) ? array(
            'name' => 'got_it',
            'value' => $model->got_it,
        ) : null,
    )),
)); ?>
