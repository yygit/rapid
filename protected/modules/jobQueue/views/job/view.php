<?php
/* @var $this JobController */
/* @var $model Job */

$this->breadcrumbs = array(
    'Jobs' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Job', 'url' => array('index')),
    array('label' => 'Create Job', 'url' => array('create')),
    array('label' => 'Update Job', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Job', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Job', 'url' => array('admin')),
);
?>

<h1>View Job #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'action',
        array(
            'label' => 'Num of scheds',
            'type' => 'raw',
            'value' => count($model->jobsScheduled),
        ),

    ),
)); ?>
