<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */
/* @var $isPlot boolean */

$this->breadcrumbs = array(
    'Job Scheduleds' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List Job Scheds', 'url' => array('jobScheduled/index'), 'authItemName' => 'jobQueue@JobScheduledIndex'),
    array('label' => 'Create Job Sched', 'url' => array('jobScheduled/create'), 'authItemName' => 'jobQueue@JobScheduledCreate'),
    array('label' => 'Update Job Sched', 'url' => array('jobScheduled/update', 'id' => $model->id), 'authItemName' => 'jobQueue@JobScheduledUpdate'),
    array('label' => 'Delete Job Sched', 'url' => '#', 'linkOptions' => array('submit' => array('jobScheduled/delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?'), 'authItemName' => 'jobQueue@JobScheduledDelete'),
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
    $this->widget('jobQueue.extensions.EFlot.EFlotGraphWidget', json_decode($model->output, true));
}


?>
