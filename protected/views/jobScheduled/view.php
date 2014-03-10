<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */
/* @var $isPlot boolean */

$this->breadcrumbs = array(
    'Job Scheduleds' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List JobScheduled', 'url' => array('index')),
    array('label' => 'Create JobScheduled', 'url' => array('create')),
    array('label' => 'Update JobScheduled', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete JobScheduled', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>View Scheduled Job #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'params',
        'output',
        'job.name',
        'scheduled_time',
        'started',
        'completed',
        array(
            'name' => 'active',
            'value' => $model->active ? 'true' : 'false',
        ),
    ),
));

if (!empty($model->output) && !empty($isPlot)) {
    $this->widget('ext.EFlot.EFlotGraphWidget', json_decode($model->output, true));
}


?>
