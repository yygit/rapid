<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-scheduled-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'job_id'); ?>
        <?php echo $form->dropDownList($model, 'job_id', Job::model()->getOptions()); ?>
        <?php echo $form->error($model, 'job_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'params'); ?>
        <?php echo $form->textArea($model, 'params', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'params'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'scheduled_time'); ?>
        <?php $this->widget('jobQueue.extensions.timepicker.timepicker', array(
            'model' => $model,
            'name' => 'scheduled_time',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'altFormat' => 'yy-mm-dd',
            ),
        ));
        ?>
        <?php echo $form->error($model, 'scheduled_time'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'active'); ?>
        <?php echo $form->checkbox($model, 'active'); ?>
        <?php echo $form->error($model, 'active'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
