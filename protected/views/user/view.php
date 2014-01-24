<?php
/* @var $this UserController */
/* @var $model User */
/* @var $isAudit boolean */

/*$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);*/

$this->breadcrumbs = array(
    'Users' => Yii::app()->user->checkAccess('manageUser') ? array('index') : null,
    $model->id,
);

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
    array('label' => 'Update User', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
//	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'username',
        /*'pwd_hash',*/
        'person.fname',
        'person.lname',
    ),
));

if ($isAudit) {
    echo '<br><br>';
    $this->widget('application.modules.auditTrail.widgets.portlets.ShowAuditTrail', array(
            'model' => $model,
        )
    );
}



?>
