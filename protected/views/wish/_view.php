<?php
/* @var $this WishController */
/* @var $data Wish */

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/wish_list_ajax.js');
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::encode($data->id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('issue_number')); ?>:</b>
    <?php echo CHtml::encode($data->issue_number); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
    <?php /*echo CHtml::encode($data->type_id); */?>
    <?php echo CHtml::encode($data->type->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('publication_date')); ?>:</b>
    <?php echo CHtml::encode($data->publication_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('store_link')); ?>:</b>
    <?php
    $storeLink = empty($data->store_link) ? 'No link provided' : '<a href="' . CHtml::encode($data->store_link) . '" target="_blank">Purchase</a>';
    echo $storeLink;
    ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
    <?php echo CHtml::encode($data->notes); ?>
    <br/>

    <?php if (Yii::app()->user->getName() != 'admin') { ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('got_it')); ?>:</b>
        <?php
        echo CHtml::checkBox("got",
            ($data->got_it == Yii::app()->user->getId()),
            array(
                'class' => 'claim',
                'url' => Yii::app()->controller->createUrl("claim", array("id" => $data->id)),
                'wishid' => $data->id,
            )
        );
        ?>
    <?php } ?>
    <br/>

</div>
