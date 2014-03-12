<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs = array(
    'Job Scheduleds' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List JobScheduled', 'url' => array('index'), 'authItemName' => 'jobQueue@JobScheduledIndex'),
    array('label' => 'Create JobScheduled', 'url' => array('create'), 'authItemName' => 'jobQueue@JobScheduledCreate'),
    array('label' => 'View JobScheduled', 'url' => array('view', 'id' => $model->id), 'authItemName' => 'jobQueue@JobScheduledView'),
);
?>

<h1>Update JobScheduled <?php echo ' "' . $model->job->name . '" (#' . $model->id . ')'; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
