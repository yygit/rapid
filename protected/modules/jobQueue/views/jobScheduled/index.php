<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs = array(
    'Job Schedules',
);

$this->menu = array(
    array('label' => 'Create Job Schedule', 'url' => array('jobScheduled/create'), 'authItemName' => 'jobQueue@JobScheduledCreate'),
    array('label' => 'List Registered Jobs', 'url' => array('job/index'), 'authItemName' => 'jobQueue@JobIndex'),
    array('label' => 'Register Job', 'url' => array('job/create'), 'authItemName' => 'jobQueue@JobCreate'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#job-scheduled-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('disableClick', "
    $('input:checkbox[name=active]').bind('click', false);
",CClientScript::POS_END);
?>

<h1>Manage Job Schedules</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'afterAjaxUpdate' => 'function(id, data){$("input:checkbox[name=active]").bind("click", false);}',
    'id' => 'job-scheduled-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'params',
        'output',
        'job_id',
        array(
            'name' => 'job_name',
            'value' => '$data->job->name',
        ),
        'scheduled_time',
        'started',
        'completed',
        /*
        'completed',
        */
        array(
            'name' => 'active',
            'value' => 'CHtml::checkBox("active", $data->active)',
            'type' => 'raw',
            'filter' => array(1 => 'yes', 0 => 'no'),
        ),
        /*array(
            'class' => 'CCheckBoxColumn',
            'id' => 'active',
            'header' => 'Active',
            'checked' => '$data->active',
            'selectableRows' => 0,
        ),*/
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
