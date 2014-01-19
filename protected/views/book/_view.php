<?php
/* @var $this BookController */
/* @var $data Book */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('issue_number')); ?>:</b>
	<?php echo CHtml::encode($data->issue_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
	<?php echo CHtml::encode($data->type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publication_date')); ?>:</b>
	<?php echo CHtml::encode($data->publication_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('lendable')); ?>:</b>
    <?php echo CHtml::encode($data->lendable); ?>
    <br/>

    <?php
    echo "<b>" . CHtml::encode($data->getAttributeLabel('borrower')) . ":</b> ";
    /*BookController::set_fullname($data);
    echo CHtml::encode($data->borrower_fullname);*/
    echo CHtml::encode($data->borrower ? $data->borrower->person->fname.' '. $data->borrower->person->lname : '');
    ?>
    <br/>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('signed')); ?>:</b>
	<?php echo CHtml::encode($data->signed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade_id')); ?>:</b>
	<?php echo CHtml::encode($data->grade_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bagged')); ?>:</b>
	<?php echo CHtml::encode($data->bagged); ?>
	<br />

	*/ ?>

</div>
