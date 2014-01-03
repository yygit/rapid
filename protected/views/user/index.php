<?php
/* @var $this UserController */
/* @var $model User */
/* @var $data User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List User', 'url'=>array('index')),
//	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->
<ul>
    <li>
        <?php echo CHtml::link('Create User', array('create')); ?>
    </li>

    <li>
        <?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
    </li>
</ul>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
//		'pwd_hash',
//		'person_id',
        array(
            'name' => 'person_fname',
            'header' => Person::model()->getAttributeLabel("fname"),
            'value' => '$data->person->fname',
        ),
        array(
            'name' => 'person_lname',
            'header' => Person::model()->getAttributeLabel("lname"),
            'value' => '$data->person->lname',
        ),

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
