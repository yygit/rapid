<?php
/* @var $this JobController */
/* @var $model Job */

$this->breadcrumbs = array(
    'Manage Registered Jobs',
);

$this->menu = array(
//    array('label' => 'Create Job', 'url' => array('create')),
    array('label' => 'Job Schedules', 'url' => array('jobScheduled/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#job-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Registered Jobs</h1>

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

<div class="right">
    <?php
    EQuickDlgs::iframeButton(
        array(
            'controllerRoute' => 'create',
            'dialogTitle' => 'Create item',
            'dialogWidth' => 600,
            'dialogHeight' => 400,
            'openButtonText' => 'Register New Job',
            'closeButtonText' => 'Close',
            'closeOnAction' => true, //important to invoke the close action in the actionCreate
            'refreshGridId' => 'job-grid', //the grid with this id will be refreshed after closing; jQuery('#job-grid').yiiGridView('update');
            'contentWrapperHtmlOptions' => array('style' => 'height:250px;'),
        ));
    ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'job-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        'action',
        /*array(
            'class' => 'CButtonColumn',
        ),*/
        array(
            'class' => 'EJuiDlgsColumn',
            'updateDialog' => array(
                'dialogWidth' => 580,
                'dialogHeight' => 270,
                'contentWrapperHtmlOptions' => array('style' => 'height:210px;'),
            ),
            'viewDialog' => array(
                'dialogWidth' => 580,
                'dialogHeight' => 250,
            ),
        ),
    ),
)); ?>
