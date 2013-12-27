<?php
/* @var $this CController */

echo '<a data-ajax="false" href="' . $this->createUrl('view', array('id' => $data->id)) . '">';
echo '<h1>' . CHtml::encode($data->title);
if (!empty($data->issue_number)) {
    echo ' Issue: ' . CHtml::encode($data->issue_number);
}
echo '</h1>';
echo '<p>' . CHtml::encode($data->notes) . '</p></a>';
?>

