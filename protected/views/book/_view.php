<?php
/* @var $this BookController */
/* @var $data Book */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('issue_number')); ?>:</b>
    <?php echo CHtml::encode($data->issue_number); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type_id')); ?>:</b>
    <?php echo CHtml::encode($data->type_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('publication_date')); ?>:</b>
    <?php echo CHtml::encode($data->publication_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
    <?php echo CHtml::encode($data->value); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
    <?php echo CHtml::encode($data->price); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
    <?php echo CHtml::encode($data->notes); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('lendable')); ?>:</b>
    <?php echo CHtml::encode($data->lendable); ?>
    <br/>

    <?php
    echo "<b>" . CHtml::encode($data->getAttributeLabel('borrower')) . ":</b> ";
    // use CHtml::encode in Person model filter
    echo $data->borrower ? $data->borrower->person->fname . ' ' . $data->borrower->person->lname . "&nbsp;" .
        CHtml::link("Return", array("library/return", "book_id" => $data->id, "user_id" => $data->borrower_id)) : '';
    ?>
    <br/>

    <?php
    if ($data->requesters) {
        echo "<strong>Requests</strong>\n";
        echo "<ul>\n";
        foreach ($data->requesters as $r) {
            echo "<li>" . CHtml::encode($r->person->fname . ' ' . $r->person->lname) . "&nbsp;" . CHtml::link("Lend",
                    array("library/lend",
                        "book_id" => $data->id,
                        "user_id" => $r->id)) .
                "</li>";
        }
        echo "</ul>\n";
    }
    ?>

</div>
